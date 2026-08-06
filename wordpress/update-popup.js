/**
 * Shelter Map Popup Data Update
 * Updates .js-map-marker-popup with data from API when marker is clicked
 * Includes review form submission
 */

(function($) {
  'use strict';

  // Cache API data
  let sheltersData = null;
  let currentShelterId = null;

  /**
   * Fetch shelters data from API
   */
  async function fetchSheltersData() {
    if (sheltersData) {
      return sheltersData;
    }

    try {
      const response = await fetch(shelterMapPopupData.home + '/wp-json/shelters/v1/list');
      if (!response.ok) {
        throw new Error('API request failed');
      }
      sheltersData = await response.json();
      return sheltersData;
    } catch (error) {
      console.error('Error fetching shelters data:', error);
      return null;
    }
  }

  /**
   * Generate star rating HTML
   */
  function generateStarRating(rating, totalReviews = 0) {
    const fullStars = Math.floor(rating);
    const emptyStars = 5 - fullStars;
    const themeUrl = shelterMapPopupData.themeUrl;

    let starsHTML = '<ul class="stars_rating">';

    // Full stars
    for (let i = 0; i < fullStars; i++) {
      starsHTML += `
        <div class="stars_rating__item">
          <span class="icon icon--size_mod" data-sprite-icon="star">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
              <use xlink:href="${themeUrl}/images/sprite/sprite.svg#star"></use>
            </svg>
          </span>
        </div>`;
    }

    // Empty stars
    for (let i = 0; i < emptyStars; i++) {
      starsHTML += `
        <div class="stars_rating__item">
          <span class="icon icon--size_mod" data-sprite-icon="star-outline">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
              <use xlink:href="${themeUrl}/images/sprite/sprite.svg#star-outline"></use>
            </svg>
          </span>
        </div>`;
    }

    starsHTML += '</ul>';

    if (totalReviews > 0) {
      starsHTML += `<div class="map_popup__rating_total">(${totalReviews})</div>`;
    }

    return starsHTML;
  }

  /**
   * Generate info item HTML
   */
  function generateInfoItem(icon, label) {
    const themeUrl = shelterMapPopupData.themeUrl;
    const iconSize = icon === 'bunker' ? '24' : '22';

    return `
      <div class="map_popup__info_item">
        <div class="map_popup__filter_icon">
          <span class="icon icon--size_mod" data-sprite-icon="${icon}">
            <svg width="${iconSize}" height="${iconSize}" viewBox="0 0 ${iconSize} ${iconSize}" fill="none" xmlns="http://www.w3.org/2000/svg">
              <use xlink:href="${themeUrl}/images/sprite/sprite.svg#${icon}"></use>
            </svg>
          </span>
        </div>
        <div class="map_popup__info_label">${label}</div>
      </div>`;
  }

  /**
   * Generate gallery HTML
   */
  function generateGallery(images) {
    if (!images || images.length === 0) {
      return '';
    }

    const themeUrl = shelterMapPopupData.themeUrl;
    let galleryHTML = `
      <div class="map_popup__block gallery_v1" data-gallery-section="">
        <div class="map_popup__block_title">Фото</div>
        <div class="map_popup__gallery">
          <div class="map_popup__gallery_arrow map_popup__gallery_arrow--prev_mod" data-gallery-prev-arrow="">
            <span class="icon icon--size_mod" data-sprite-icon="chevron-right">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <use xlink:href="${themeUrl}/images/sprite/sprite.svg#chevron-right"></use>
              </svg>
            </span>
          </div>
          <div class="map_popup__gallery_arrow map_popup__gallery_arrow--next_mod" data-gallery-next-arrow="">
            <span class="icon icon--size_mod" data-sprite-icon="chevron-right">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <use xlink:href="${themeUrl}/images/sprite/sprite.svg#chevron-right"></use>
              </svg>
            </span>
          </div>
          
          <div class="map_popup__gallery_list swiper" data-gallery-slider="">
            <div class="swiper-wrapper">`;

    images.forEach(image => {
      galleryHTML += `
        <div class="map_popup__gallery_item swiper-slide">
          <picture class="map_popup__gallery_image">
            <img class="map_popup__gallery_image_el" src="${image}" alt="Shelter Photo" loading="lazy">
          </picture>
        </div>`;
    });

    galleryHTML += `
            </div>
          </div>
        </div>
      </div>`;

    return galleryHTML;
  }

  function generateGalleryV2(images) {
    if (!images || images.length === 0) {
      return '';
    }

    const themeUrl = shelterMapPopupData.themeUrl;
    let galleryHTML2 = `
      <div class="map_popup__block gallery_v2">
        <div class="map_popup__block_title">Фото</div>
        <div class="map_popup__gallery_v2">
        `
    images.forEach(image => {
      galleryHTML2 += `
              <div class="map_popup__gallery_v2_item">
                <picture class="map_popup__gallery_v2_image">
                  <img class="map_popup__gallery_v2_image_el" src="${image}" alt="Content Picture" loading="lazy" />
                </picture>
              </div>`;
    });
    galleryHTML2 +=
      `</div>
        </div>
      </div>`;

    return galleryHTML2;
  }

  /**
   * Generate reviews HTML
   */
  /**
   * Generate reviews HTML with images
   */
  function generateReviews(reviews) {
    if (!reviews || reviews.length === 0) {
      return '<ul class="map_popup__reviews_list"><li class="map_popup__no_reviews"><p>Відгуків ще немає. Будьте першим!</p></li></ul>';
    }

    const themeUrl = shelterMapPopupData.themeUrl;
    let reviewsHTML = '<ul class="map_popup__reviews_list">';

    reviews.forEach(review => {
      const fullStars = Math.floor(review.stars || 0);
      const emptyStars = 5 - fullStars;

      reviewsHTML += `
      <li class="map_popup__review">
        <div class="map_popup__review_name">${escapeHTML(review.name || 'Анонім')}</div>
        <div class="map_popup__review_head">
          <div class="map_popup__review_stars">
            <ul class="stars_rating">`;

      // Full stars
      for (let i = 0; i < fullStars; i++) {
        reviewsHTML += `
        <div class="stars_rating__item">
          <span class="icon icon--size_mod" data-sprite-icon="star">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
              <use xlink:href="${themeUrl}/images/sprite/sprite.svg#star"></use>
            </svg>
          </span>
        </div>`;
      }

      // Empty stars
      for (let i = 0; i < emptyStars; i++) {
        reviewsHTML += `
        <div class="stars_rating__item">
          <span class="icon icon--size_mod" data-sprite-icon="star-outline">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
              <use xlink:href="${themeUrl}/images/sprite/sprite.svg#star-outline"></use>
            </svg>
          </span>
        </div>`;
      }

      reviewsHTML += `
            </ul>
          </div>
          <div class="map_popup__review_date">${review.date || ''}</div>
          <div class="map_popup__review_time">${review.time || ''}</div>
        </div>
        <div class="map_popup__review_text">${escapeHTML(review.text || '')}</div>`;

      // Add images if any
      if (review.images && review.images.length > 0) {
        reviewsHTML += `<div class="map_popup__gallery">`;
        reviewsHTML += `
          <div class="map_popup__gallery_arrow map_popup__gallery_arrow--prev_mod" data-gallery-prev-arrow="">
            <span class="icon icon--size_mod" data-sprite-icon="chevron-right">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <use xlink:href="${themeUrl}/images/sprite/sprite.svg#chevron-right"></use>
              </svg>
            </span>
          </div>
          <div class="map_popup__gallery_arrow map_popup__gallery_arrow--next_mod" data-gallery-next-arrow="">
            <span class="icon icon--size_mod" data-sprite-icon="chevron-right">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <use xlink:href="${themeUrl}/images/sprite/sprite.svg#chevron-right"></use>
              </svg>
              </span>
          </div>
					<div class="map_popup__gallery_list swiper" data-gallery-slider="">
					  <div class="swiper-wrapper">`;
        review.images.forEach(imgUrl => {
          reviewsHTML += `
            <div class="map_popup__gallery_item swiper-slide">
              <picture class="map_popup__gallery_image">
                <img class="map_popup__gallery_image_el" src="${imgUrl}" alt="Content Picture" loading="lazy"/>
              </picture>
            </div>
      `;
        });
        reviewsHTML += `</div></div></div>`;
      }

      reviewsHTML += `</li>`;
    });

    reviewsHTML += '</ul>';

    if (reviews.length > 5) {
      reviewsHTML += '<button class="map_popup__reviews_all" type="button">Переглянути ще відгуки</button>';
    }

    return reviewsHTML;
  }

  /**
   * Escape HTML to prevent XSS
   */
  function escapeHTML(str) {
    if (!str) return '';
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  /**
   * Get selected rating from radio buttons
   */
  function getSelectedRating() {
    const checked = document.querySelector('input[name="review_popup"]:checked');
    return checked ? parseInt(checked.value) : 5;
  }

  /**
   * Reset review form
   */
  function resetReviewForm() {
    const $form = $('.map_popup__form_el');

    // Reset inputs
    $('#review_popup_name').val('');
    $('#review_text').val('');

    // Reset star rating to default (5 stars)
    $('input[name="review_popup"]').prop('checked', false);

    // Clear uploaded images
    $('.js-image-upload-gallery').empty();
    $('.js-image-upload-input').val('');

    // Hide message
    $('.map_popup__form_message').remove();
  }

  /**
   * Show form message
   */
  function showFormMessage(message, type) {
    // Remove existing message
    $('.map_popup__form_message').remove();

    const messageHTML = `<div class="map_popup__form_message map_popup__form_message--${type}">${message}</div>`;

    // Insert before buttons
    $('.map_popup__popup_buttons').before(messageHTML);

    // Auto-hide success message
    if (type === 'success') {
      setTimeout(() => {
        $('.map_popup__form_message').fadeOut(300, function() {
          $(this).remove();
        });
      }, 5000);
    }
  }

  /**
   * Submit review to API
   */
  async function submitReview(formData) {
    try {
      const response = await fetch('https://www.slidstvo.info/wp-json/shelters/v1/review', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
      });

      const result = await response.json();

      if (!response.ok) {
        throw new Error(result.message || 'Помилка надсилання');
      }

      return result;
    } catch (error) {
      console.error('Error submitting review:', error);
      throw error;
    }
  }

  /**
   * Upload images and get URLs
   */
  async function uploadImages(files) {
    if (!files || files.length === 0) {
      return [];
    }

    const uploadedUrls = [];

    for (const file of files) {
      try {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('action', 'shelter_upload_image');
        formData.append('nonce', shelterMapPopupData.nonce || '');

        const response = await fetch(shelterMapPopupData.ajaxUrl || '/wp-admin/admin-ajax.php', {
          method: 'POST',
          body: formData,
        });

        const result = await response.json();

        if (result.success && result.data.url) {
          uploadedUrls.push(result.data.url);
        }
      } catch (error) {
        console.error('Error uploading image:', error);
      }
    }

    return uploadedUrls;
  }

  /**
   * Add pending review to list
   */
  function addPendingReview(reviewData) {
    const themeUrl = shelterMapPopupData.themeUrl;
    const $reviewsList = $('.map_popup__reviews_list');

    // Remove "no reviews" message if present
    $reviewsList.find('.map_popup__no_reviews').remove();

    // Generate stars HTML
    const rating = reviewData.rating;
    let starsHTML = '<ul class="stars_rating">';
    for (let i = 1; i <= 5; i++) {
      const iconName = i <= rating ? 'star' : 'star-outline';
      starsHTML += `
        <div class="stars_rating__item">
          <span class="icon icon--size_mod" data-sprite-icon="${iconName}">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
              <use xlink:href="${themeUrl}/images/sprite/sprite.svg#${iconName}"></use>
            </svg>
          </span>
        </div>`;
    }
    starsHTML += '</ul>';

    const now = new Date();
    const date = now.toLocaleDateString('uk-UA', { day: '2-digit', month: '2-digit', year: '2-digit' }).replace(/\//g, '.');
    const time = now.toLocaleTimeString('uk-UA', { hour: '2-digit', minute: '2-digit' });

    const pendingReviewHTML = `
      <li class="map_popup__review map_popup__review--pending">
        <div class="map_popup__review_pending_badge">На модерації</div>
        <div class="map_popup__review_name">${escapeHTML(reviewData.name)}</div>
        <div class="map_popup__review_head">
          <div class="map_popup__review_stars">${starsHTML}</div>
          <div class="map_popup__review_date">${date}</div>
          <div class="map_popup__review_time">${time}</div>
        </div>
        <div class="map_popup__review_text">${escapeHTML(reviewData.text)}</div>
      </li>`;

    $reviewsList.prepend(pendingReviewHTML);
  }

  /**
   * Update popup with shelter data
   */
  function updateMarkerPopup(shelterData) {

    const $popup = $('.js-map-marker-popup');
    const $reviewTitle = $popup.find('.js-review-address');
    const $popupTitle = $popup.find('.map_popup__title');
    const $popupInfo = $popup.find('.map_popup__excerpt');


    if (!$popup.length || !shelterData) {
      console.error('Popup element not found or no data provided', {
        popupFound: $popup.length > 0,
        dataProvided: !!shelterData
      });
      return;
    }

    // Store current shelter ID globally
    currentShelterId = shelterData.id;

    // Update hidden shelter_id input in form (add if not exists)
    let $shelterIdInput = $('.map_popup__form_el input[name="shelter_id"]');
    if ($shelterIdInput.length === 0) {
      $('.map_popup__form_el').prepend(`<input type="hidden" name="shelter_id" value="${shelterData.id}">`);
    } else {
      $shelterIdInput.val(shelterData.id);
    }

    if (shelterData.type === 'child_death' || shelterData.type === 'destroyed_building') {
      $('.map_popup__rating').hide();
      $('.map_popup__info--v1_mod').hide();
      $('.map__reviews').hide();
    } else {
      $popupTitle.html('Укриття');
      $('.map_popup__rating').show();
      $('.map_popup__info--v1_mod').show();
      $('.map__reviews').show();
    }

    if (shelterData.type === 'child_death' || shelterData.type === 'destroyed_building') {
      $popupTitle.html('Зруйнований будинок, де загинула дитина');
    }
    if (shelterData.type === 'destroyed_building') {
      $popupTitle.html('Зруйнований будинок');
    }
    if (shelterData.type === 'expensive_shelters') {
      $popupTitle.html(' Про укриття (одне з найдорожчих)');
    }

    const not_homes = [38321, 38322, 38323, 38324];

    if (not_homes.includes(shelterData.id)) {
      $popupTitle.html('Зруйнована будівля, де загинула дитина');
    }

    if (shelterData.info) {
      $popupInfo.html(shelterData.info)
    } else {
      $popupInfo.html('');
    }
    // Calculate average rating from reviews
    let avgRating = 0;
    let reviewsCount = shelterData.reviews ? shelterData.reviews.length : 0;

    if (shelterData.review_stats) {
      avgRating = shelterData.review_stats.average || 0;
      reviewsCount = shelterData.review_stats.count || 0;
    } else if (shelterData.reviews && shelterData.reviews.length > 0) {
      const totalStars = shelterData.reviews.reduce((sum, r) => sum + (r.stars || r.rating || 0), 0);
      avgRating = totalStars / shelterData.reviews.length;
    }

    // Update rating
    const ratingHTML = generateStarRating(avgRating, reviewsCount);
    $popup.find('.map_popup__rating').html(ratingHTML);

    function formatValue(value, suffix = '') {
      // Empty values
      if (value === null || value === undefined || value === '') {
        return 'Інформація відсутня';
      }

      // Boolean values
      if (value === true) return value;
      if (value === false) return 'Інформація відсутня';

      // Regular values with optional suffix
      return suffix ? `${value} ${suffix}` : value;
    }


    // Update info items
    const infoItems = [
      { icon: 'map', label: `Район: ${shelterData.district_cyr || shelterData.district || 'Не вказано'}` },
      { icon: 'marker', label: `Адреса: ${shelterData.adress || 'Не вказано'}` },
      { icon: 'shield', label: `Тип: ${shelterData.variant || shelterData.type_cyr || 'Не вказано'}` },
      { icon: 'bunker', label: `Вид: ${shelterData.option || shelterData.kind || 'Не вказано'}` },
      { icon: 'accessibility-sign', label: `Інклюзивність: ${formatValue(shelterData.inclusive)}` },
      { icon: 'clock', label: `Режим роботи: ${formatValue(shelterData.fullday)}` },
      { icon: 'hammer-outline', label: `Стан: ${shelterData.condition || 'Не вказано'}` },
      { icon: 'sofa', label: `Місце для сидіння: ${formatValue(shelterData.seats)}` },
      { icon: 'badge-wc', label: `Туалет: ${formatValue(shelterData.wc)}` },
      { icon: 'water tap', label: `Вода: ${formatValue(shelterData.water)}` },
      { icon: 'number', label: `Місткість: ${shelterData.capacity || 'Не вказано'} людей` },
      { icon: 'area-search', label: `Площа: ${
          shelterData.square || shelterData.area
            ? `${shelterData.square || shelterData.area} м²`
            : 'Інформація відсутня'
        }` },

    ];

    const expensiveItems = [
      { icon: 'map', label: `Район: ${shelterData.district_cyr || 'Не вказано'}` },
      { icon: 'marker', label: `Адреса: ${shelterData.adress || 'Не вказано'}` },
    ]

    let infoHTML = '<div class="map_popup__info_in">';
    if (shelterData.destroyed == null || shelterData.destroyed.when === '') {

      if(shelterData.type === 'expensive_shelters') {
        $popup.find('.map_popup__info--v1_mod').addClass('map_popup__info--expensive_mod');
        expensiveItems.forEach(item => {
          infoHTML += generateInfoItem(item.icon, item.label);
        });
      } else {
        $popup.find('.map_popup__info--v1_mod').removeClass('map_popup__info--expensive_mod');
        infoItems.forEach(item => {
          infoHTML += generateInfoItem(item.icon, item.label);
        });
      }
      infoHTML += '</div>';
      $popup.find('.map_popup__info--v1_mod').html(infoHTML);
      $popup.find('.map_popup__info--v2_mod').html('');
      $reviewTitle.html('Адреса: ' + shelterData.adress)
    } else {
      let destroyedItems = [
        { icon: 'map', label: `Район: ${shelterData.destroyed.district || 'Не вказано'}` },
        { icon: 'marker', label: `Адреса: ${shelterData.destroyed.address || 'Не вказано'}` },
        { icon: 'heart-broken', label: `Загинули: ${shelterData.destroyed.dead || 'Не вказано'}` },
        { icon: 'question-mark', label: `Від чого: ${shelterData.destroyed.reason || 'Не вказано'}` },
        { icon: 'calendar', label: `Коли: ${shelterData.destroyed.when || 'Не вказано'}` },
      ]
      destroyedItems.forEach(item => {
        infoHTML += generateInfoItem(item.icon, item.label);
      });
      infoHTML += '</div>';
      $popup.find('.map_popup__info--v1_mod').html('');
      $popup.find('.map_popup__info--v2_mod').html(infoHTML);
      $reviewTitle.html('Адреса: ' + shelterData.destroyed.address)
    }



// Update gallery
    const galleryHTML = generateGallery(shelterData.gallery);
    const galleryV2HTML = generateGalleryV2(shelterData.gallery);
    const $existingGallery = $popup.find('[data-gallery-section]');

    if (shelterData.destroyed.when == '' || shelterData.destroyed.when === null) {
      console.log('when empty');
      $popup.find('.gallery_v2').remove();
      if (galleryHTML) {

        // Destroy existing swiper first
        const existingSlider = $existingGallery.find('[data-gallery-slider]')[0];
        if (existingSlider && existingSlider.swiper) {
          existingSlider.swiper.destroy(true, true);
        }

        // Replace HTML
        if ($existingGallery.length) {
          $existingGallery.replaceWith(galleryHTML);
        } else {
          $popup.find('.map_popup__info--v1_mod').after(galleryHTML);
        }

        // Reinitialize Swiper
        setTimeout(() => {
          if (typeof window.initGallerySwiper === 'function') {
            window.initGallerySwiper();
          } else {
            document.dispatchEvent(new CustomEvent('gallery:reinit'));
          }
        }, 200);

      } else {
        // Destroy and remove
        const existingSlider = $existingGallery.find('[data-gallery-slider]')[0];
        if (existingSlider && existingSlider.swiper) {
          existingSlider.swiper.destroy(true, true);
        }
        $existingGallery.remove();
      }
    } else if(shelterData.destroyed.when != '' || shelterData.destroyed !== null) {
      console.log('when not empty');
      $popup.find('.gallery_v2').remove();
      $popup.find('.map_popup__info--v2_mod').after(galleryV2HTML);
      $popup.find('.gallery_v1').hide();
    }




    // Update reviews section
    const $reviewsWrap = $popup.find('.map_popup__reviews_wrap');

    // Generate reviews list
    const reviewsHTML = generateReviews(shelterData.reviews);

    // Replace reviews list
    const $reviewsList = $reviewsWrap.find('.map_popup__reviews_list');
    if ($reviewsList.length) {
      $reviewsList.replaceWith(reviewsHTML);
    } else {
      $reviewsWrap.find('.map_popup__reviews_btn').after(reviewsHTML);
    }

    // Remove old "show more" button
    $reviewsWrap.find('.map_popup__reviews_all').remove();

    // Add new "show more" button if needed
    if (shelterData.reviews && shelterData.reviews.length > 5) {
      $reviewsWrap.find('.map_popup__reviews_list').after('<button class="map_popup__reviews_all" type="button">Переглянути ще відгуки</button>');
    }

    // Reset review form
    resetReviewForm();
  }

  /**
   * Initialize review form event handlers
   */
  function initReviewFormHandlers() {
    const $body = $(document.body);

    // Handle form submission (click on "Опублікувати відгук" button)
    $body.on('click', '.map_popup__form_el .btn_v3:not(.js-map-review-back)', async function(e) {
      e.preventDefault();

      const $btn = $(this);
      const $form = $btn.closest('.map_popup__form_el');

      // Prevent double submission
      if ($btn.prop('disabled')) {
        return;
      }

      // Get form data
      const name = $('#review_popup_name').val().trim();
      const text = $('#review_text').val().trim();
      const rating = getSelectedRating();
      const shelterId = currentShelterId || $form.find('input[name="shelter_id"]').val();

      // Validation
      if (!shelterId) {
        showFormMessage('Помилка: укриття не вибрано', 'error');
        return;
      }

      if (!name) {
        showFormMessage("Введіть ваше ім'я", 'error');
        $('#review_popup_name').focus();
        return;
      }

      if (!text) {
        showFormMessage('Введіть текст відгуку', 'error');
        $('#review_text').focus();
        return;
      }

      if (text.length < 10) {
        showFormMessage('Відгук занадто короткий (мін. 10 символів)', 'error');
        $('#review_text').focus();
        return;
      }

      // Disable button
      $btn.prop('disabled', true).text('Надсилання...');

      try {
        // Upload images first (if any)
        const fileInput = document.querySelector('.js-image-upload-input');
        let imageUrls = [];

        if (fileInput && fileInput.files.length > 0) {
          imageUrls = await uploadImages(fileInput.files);
        }

        // Submit review
        const formData = {
          shelter_id: parseInt(shelterId),
          name: name,
          email: '', // Optional, not in your form
          rating: rating,
          text: text,
          images: imageUrls
        };

        console.log('Submitting review:', formData);

        const result = await submitReview(formData);
        console.log(result);

        if (result.success) {
          $('.js-map-marker-popup').addClass('map_popup--submitted_mod');

          // Add pending review to list
          addPendingReview({
            name: name,
            rating: rating,
            text: text
          });

          // Reset form
          resetReviewForm();

          // Close form section after delay (if you have toggle)
          setTimeout(() => {
            // Trigger back button to close form section if needed
            // $('.js-map-review-back').trigger('click');
          }, 2000);

        } else {
          showFormMessage(result.message || 'Помилка надсилання', 'error');
        }

      } catch (error) {
        console.error('Review submit error:', error);
        showFormMessage(error.message || "Помилка з'єднання. Спробуйте пізніше.", 'error');
      }

      // Re-enable button
      $btn.prop('disabled', false).text('Опублікувати відгук');
    });

    // Handle cancel button
    $body.on('click', '.js-map-review-back', function(e) {
      e.preventDefault();
      resetReviewForm();
      // If you have a panel that needs to close, handle it here
    });

    // Handle form submit event (for Enter key)
    $body.on('submit', '.map_popup__form_el', function(e) {
      e.preventDefault();
      // Trigger the submit button click
      $(this).find('.btn_v3:not(.js-map-review-back)').trigger('click');
    });

    // Character counter for textarea
    $body.on('input', '#review_text', function() {
      const length = $(this).val().length;
      const maxLength = $(this).attr('maxlength') || 300;

      // Update counter if exists, or create one
      let $counter = $(this).closest('.form_textarea').find('.form_textarea__counter');
      if ($counter.length === 0) {
        $(this).closest('.form_textarea__field').after(`<div class="form_textarea__counter">${length}/${maxLength}</div>`);
      } else {
        $counter.text(`${length}/${maxLength}`);
      }
    });
  }

  /**
   * Handle marker click - called from your existing marker.addListener
   */
  window.updateShelterPopupData = function(shelterId) {
    console.log('updateShelterPopupData called with ID:', shelterId);

    fetchSheltersData().then(data => {

      if (!data) {
        return;
      }

      // Find shelter by ID
      const shelter = data.find(s => s.id == shelterId);

      if (shelter) {
        updateMarkerPopup(shelter);
      } else {
        console.error('Shelter not found. Looking for ID:', shelterId, 'Available IDs:', data.map(s => s.id));
      }
    }).catch(error => {
      console.error('Error in updateShelterPopupData:', error);
    });
  };

  // Also keep the old name for backwards compatibility
  window.markerClickHandler = window.updateShelterPopupData;

  // Pre-fetch data on page load for better performance
  $(document).ready(function() {

    // Initialize review form handlers
    initReviewFormHandlers();

    // Pre-fetch data
    fetchSheltersData();
  });

})(jQuery);