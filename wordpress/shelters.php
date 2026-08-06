<?php
/**
 * Map Section Shortcode
 * Usage: [shelter_map]
 */

function shelter_map_shortcode() {
  // Get theme directory URI with shelters folder
  $theme_uri = get_template_directory_uri() . '/shelters';

	wp_enqueue_script('shelter-popup-js', $theme_uri . '/js/update-popup.js', array('jquery'), '1.0.28', true);

  wp_localize_script('shelter-popup-js', 'shelterMapPopupData', array(
    'themeUrl' => $theme_uri,
    'ajaxUrl' => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('shelter_nonce'),
    'restUrl'  => rest_url( 'shelters/v1/' ),
    'home' => home_url()
  ));

  ob_start();
  ?>

  <section class="section map js-map-section">
    <div class="section_in">
      <div class="map_sponsor">
        <div class="map_sponsor__title">СПЕЦПРОЄКТ ПІДГОТОВЛЕНО ЗА ПІДТРИМКИ</div>
        <ul class="map_sponsor__logos">
          <li class="map_sponsor__logos_item">
            <img class="map_sponsor__logos_img" src="<?php echo $theme_uri; ?>/images/norway.avif" alt="">
          </li>
          <li class="map_sponsor__logos_item">
            <img class="map_sponsor__logos_img" src="<?php echo $theme_uri; ?>/images/iwpr.avif" alt="IWPR" >
          </li>
        </ul>
      </div>
      <div class="map__wrap">
        <div class="map__el js-map" data-id="1"></div>
        <div class="map_labels">
          <div class="map_labels__title">Позначення на мапі</div>
          <div class="map_labels__list">
            <div class="map_labels__item">
              <div class="map_labels__icon">
                <img class="map_labels__icon" src="<?php echo $theme_uri; ?>/images/map/location.svg" alt="">
              </div>
              <div class="map_labels__label">Укриття</div>
            </div>
            <div class="map_labels__item">
              <div class="map_labels__icon">
                <img class="map_labels__icon" src="<?php echo $theme_uri; ?>/images/map/building.svg" alt="">
              </div>
              <div class="map_labels__label">Зруйновані будинки</div>
            </div>
            <div class="map_labels__item">
              <div class="map_labels__icon">
                <img class="map_labels__icon" src="<?php echo $theme_uri; ?>/images/map/horse.svg" alt="">
              </div>
              <div class="map_labels__label">Місце загибелі дитини</div>
            </div>
            <div class="map_labels__item">
              <div class="map_labels__icon">
                <img class="map_labels__icon" src="<?php echo $theme_uri; ?>/images/map/zoom-money.svg" alt="">
              </div>
              <div class="map_labels__label">Найдорожчі укриття</div>
            </div>
          </div>
        </div>

        <button class="map_menu js-map-filters-trigger" type="button">
          <span class="map_menu__icon"></span>
        </button>

        <!-- Filter Popup -->
        <div class="map_popup js-map-filters-popup">
          <div class="map_popup__head">
            <div class="map_popup__title">Фільтри</div>
            <div class="map_popup__close js-map-popup-close">
              <span class="icon icon--size_mod" data-sprite-icon="close">
                  <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#close"></use>
                  </svg>
              </span>
            </div>
          </div>

          <div class="map_popup__data">
            <!-- Districts Filter -->
            <div class="map_popup__filter">
              <div class="map_popup__filter_trigger js-map-accordion-trigger">
                <div class="map_popup__filter_icon">
                  <span class="icon icon--size_mod" data-sprite-icon="adjustments">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#adjustments"></use>
                      </svg>
                  </span>
                </div>
                <div class="map_popup__filter_title">Райони</div>
                <div class="map_popup__filter_arrow">
                  <span class="icon icon--size_mod" data-sprite-icon="chevron-right">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#chevron-right"></use>
                      </svg>
                  </span>
                </div>
              </div>
              <div class="map_popup__filter_data js-filter-block">
                <div class="map_popup__filter_data_in">
                  <?php
                  $districts = array(
                    'all' => 'Обрати всі райони',
                    'holosiivskyy' => 'Голосіївський',
                    'darnytskyy' => 'Дарницький',
                    'desnianskyy' => 'Деснянський',
                    'dniprovskyy' => 'Дніпровський',
                    'obolonskyy' => 'Оболонський',
                    'pecherskyy' => 'Печерський',
                    'podilskyy' => 'Подільський',
                    'sviatoshynskyy' => 'Святошинський',
                    'solomianskyy' => 'Солом\'янський',
                    'shevchenkivskyy' => 'Шевченківський'
                  );

                  foreach ($districts as $key => $label) :
                    $filter_type = $key === 'all' ? 'all' : 'district';
                    ?>
                    <div class="map_popup__filter_item">
                      <div class="form_checkbox">
                        <label class="form_checkbox__block">
                          <input class="form_checkbox__element js-filter-checkbox"
                                 type="checkbox"
                                 data-filter="<?php echo $filter_type; ?>"
                                 data-key="<?php echo $key; ?>">
                          <span class="form_checkbox__label"><?php echo $label; ?></span>
                        </label>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>

            <!-- Shelters Filter -->
            <div class="map_popup__filter">
              <div class="map_popup__filter_trigger js-map-accordion-trigger">
                <div class="map_popup__filter_icon">
                  <span class="icon icon--size_mod" data-sprite-icon="bunker">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#bunker"></use>
                      </svg>
                  </span>
                </div>
                <div class="map_popup__filter_title">Укриття</div>
                <div class="map_popup__filter_arrow">
                  <span class="icon icon--size_mod" data-sprite-icon="chevron-right">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#chevron-right"></use>
                      </svg>
                  </span>
                </div>
              </div>
              <div class="map_popup__filter_data js-filter-block">
                <div class="map_popup__filter_data_in">
                  <?php
                  $shelter_filters = array(
                    'all' => 'Обрати всі види',
                    'inclusive' => 'Інклюзивні',
                    'fullday' => 'Цілодобові',
                    'condition' => 'Відремонтовані',
                    'seats' => 'Є місця для сидіння',
                    'wc' => 'Є вбиральня',
                    'gallery' => 'Є фото',
                    'reviews' => 'Є відгуки'
                  );

                  foreach ($shelter_filters as $filter => $label) :
                    ?>
                    <div class="map_popup__filter_item">
                      <div class="form_checkbox">
                        <label class="form_checkbox__block">
                          <input class="form_checkbox__element js-filter-checkbox"
                                 type="checkbox"
                                 data-filter="<?php echo $filter; ?>">
                          <span class="form_checkbox__label"><?php echo $label; ?></span>
                        </label>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>

            <div class="map_popup__filter">
              <div class="map_popup__filter_trigger js-map-accordion-trigger">
                <div class="map_popup__filter_icon">
                  <span class="icon icon--size_mod" data-sprite-icon="price-tag">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#price-tag"></use>
                    </svg>
                  </span>
                </div>
                <div class="map_popup__filter_title">Позначки</div>
                <div class="map_popup__filter_arrow">
                  <span class="icon icon--size_mod" data-sprite-icon="chevron-right">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#chevron-right"></use>
                    </svg>
                  </span>
                </div>
              </div>
              <div class="map_popup__filter_data js-filter-block">
                <div class="map_popup__filter_data_in">
                  <div class="map_popup__filter_item">
                    <div class="form_checkbox">
                      <label class="form_checkbox__block">
                        <input class="form_checkbox__element js-filter-checkbox" type="checkbox" data-filter="all" data-key="all">
                        <span class="form_checkbox__label">Обрати всі позначки</span>
                      </label>
                    </div>
                  </div>
                  <div class="map_popup__filter_item">
                    <div class="form_checkbox">
                      <label class="form_checkbox__block">
                        <input class="form_checkbox__element js-filter-checkbox" type="checkbox" data-filter="type" data-key="skhovyshche,dual_purpose">
                        <span class="form_checkbox__label">Укриття</span>
                      </label>
                    </div>
                  </div>
                  <div class="map_popup__filter_item">
                    <div class="form_checkbox">
                      <label class="form_checkbox__block">
                        <input class="form_checkbox__element js-filter-checkbox" type="checkbox" data-filter="type" data-key="destroyed_building">
                        <span class="form_checkbox__label">Зруйновані будинки</span>
                      </label>
                    </div>
                  </div>
                  <div class="map_popup__filter_item">
                    <div class="form_checkbox">
                      <label class="form_checkbox__block">
                        <input class="form_checkbox__element js-filter-checkbox" type="checkbox" data-filter="type" data-key="child_death">
                        <span class="form_checkbox__label">Місце загибелі дітей</span>
                      </label>
                    </div>
                  </div>
                  <div class="map_popup__filter_item">
                    <div class="form_checkbox">
                      <label class="form_checkbox__block">
                        <input class="form_checkbox__element js-filter-checkbox" type="checkbox" data-filter="type" data-key="expensive_shelters">
                        <span class="form_checkbox__label">Найдорожчі укриття</span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="map_popup__footer">
            <button class="map_popup__clear js-clear-filters" type="button">Очистити фільтри</button>
            <div class="map_popup__date">Мапу оновлено: 9 Жовтня 2025, 09:00</div>
          </div>
        </div>

        <!-- Marker Popup -->
        <div class="map_popup map_popup--v2_mod js-map-marker-popup">
          <div class="map_popup__thanks">
            <div class="map_popup__close map_popup__close--pos_mod js-map-popup-close">
				<span class="icon icon--size_mod" data-sprite-icon="close">
					<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
						<use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#close"></use>
					</svg>
				</span>
            </div>
            <div class="map_popup__title_v2">Дякуємо!</div>
            <div class="map_popup__thanks_text">
              <p>
                Ваш відгук передано адміністраторам на перевірку — це може зайняти
                певний час. Перевірка потрібна, щоб запобігти публікації
                забороненого контенту.
              </p>
              <p>Після успішної модерації ваш відгук буде опубліковано.</p>
            </div>
            <div class="map_popup__popup_buttons">
              <button class="btn_v3 js-map-popup-close" type="button">
                Повернутись до мапи
              </button>
            </div>
          </div>
          <div class="map_popup__form">
            <button class="map_popup__back js-map-review-back">
              <span class="icon icon--size_mod" data-sprite-icon="chevron-right">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#chevron-right"></use>
                </svg>
              </span>
            </button>
            <div class="map_popup__close map_popup__close--pos_mod js-map-popup-close">
              <span class="icon icon--size_mod" data-sprite-icon="close">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#close"></use>
                </svg>
              </span>
            </div>
            <div class="map_popup__title_v2">
              <div class="map_popup__title_icon">
                <span class="icon icon--size_mod" data-sprite-icon="marker">
                  <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#marker"></use>
                  </svg>
                </span>
              </div>
              <span class="js-review-address">Адреса: </span>
            </div>
            <form class="map_popup__form_el">
              <div class="stars_rate">
                <div class="form_input__label">
                  Оберіть кількість зірок для оцінки укриття
                </div>
                <div class="stars_rate__block">
                  <fieldset class="stars_rate__list">
                    <input class="stars_rate__input" type="radio" id="review_popup0" value="5" name="review_popup" />
                    <label class="stars_rate__label" for="review_popup0">
                      <span class="icon icon--size_mod" data-sprite-icon="star">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7.87192 7.5496L10.253 2.75341C10.5586 2.1377 11.4417 2.1377 11.7473 2.75341L14.1284 7.5496L19.4532 8.32345C20.1364 8.42273 20.4086 9.25774 19.9141 9.7367L16.0617 13.4674L16.9709 18.7379C17.0877 19.4148 16.3731 19.9309 15.7618 19.6112L11.0002 17.1215L6.23851 19.6112C5.62721 19.9309 4.91266 19.4148 5.02941 18.7379L5.93856 13.4674L2.08627 9.7367C1.59165 9.25774 1.86395 8.42273 2.54714 8.32345L7.87192 7.5496Z" fill="#FFD700" stroke="#FFD700" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                      </span>
                    </label>
                    <input class="stars_rate__input" type="radio" id="review_popup1" value="4" name="review_popup" />
                    <label class="stars_rate__label"for="review_popup1">
                      <span class="icon icon--size_mod" data-sprite-icon="star">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7.87192 7.5496L10.253 2.75341C10.5586 2.1377 11.4417 2.1377 11.7473 2.75341L14.1284 7.5496L19.4532 8.32345C20.1364 8.42273 20.4086 9.25774 19.9141 9.7367L16.0617 13.4674L16.9709 18.7379C17.0877 19.4148 16.3731 19.9309 15.7618 19.6112L11.0002 17.1215L6.23851 19.6112C5.62721 19.9309 4.91266 19.4148 5.02941 18.7379L5.93856 13.4674L2.08627 9.7367C1.59165 9.25774 1.86395 8.42273 2.54714 8.32345L7.87192 7.5496Z" fill="#FFD700" stroke="#FFD700" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                      </span>
                    </label>
                    <input class="stars_rate__input" type="radio" id="review_popup2" value="3" name="review_popup" />
                    <label class="stars_rate__label" for="review_popup2">
                      <span class="icon icon--size_mod" data-sprite-icon="star">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7.87192 7.5496L10.253 2.75341C10.5586 2.1377 11.4417 2.1377 11.7473 2.75341L14.1284 7.5496L19.4532 8.32345C20.1364 8.42273 20.4086 9.25774 19.9141 9.7367L16.0617 13.4674L16.9709 18.7379C17.0877 19.4148 16.3731 19.9309 15.7618 19.6112L11.0002 17.1215L6.23851 19.6112C5.62721 19.9309 4.91266 19.4148 5.02941 18.7379L5.93856 13.4674L2.08627 9.7367C1.59165 9.25774 1.86395 8.42273 2.54714 8.32345L7.87192 7.5496Z" fill="#FFD700" stroke="#FFD700" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                      </span>
                    </label>
                    <input class="stars_rate__input" type="radio" id="review_popup3" value="2" name="review_popup" />
                    <label class="stars_rate__label" for="review_popup3">
                      <span class="icon icon--size_mod" data-sprite-icon="star">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7.87192 7.5496L10.253 2.75341C10.5586 2.1377 11.4417 2.1377 11.7473 2.75341L14.1284 7.5496L19.4532 8.32345C20.1364 8.42273 20.4086 9.25774 19.9141 9.7367L16.0617 13.4674L16.9709 18.7379C17.0877 19.4148 16.3731 19.9309 15.7618 19.6112L11.0002 17.1215L6.23851 19.6112C5.62721 19.9309 4.91266 19.4148 5.02941 18.7379L5.93856 13.4674L2.08627 9.7367C1.59165 9.25774 1.86395 8.42273 2.54714 8.32345L7.87192 7.5496Z" fill="#FFD700" stroke="#FFD700" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                      </span>
                    </label>
                    <input class="stars_rate__input" type="radio" id="review_popup4" value="1" name="review_popup" />
                    <label class="stars_rate__label" for="review_popup4">
                      <span class="icon icon--size_mod" data-sprite-icon="star">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7.87192 7.5496L10.253 2.75341C10.5586 2.1377 11.4417 2.1377 11.7473 2.75341L14.1284 7.5496L19.4532 8.32345C20.1364 8.42273 20.4086 9.25774 19.9141 9.7367L16.0617 13.4674L16.9709 18.7379C17.0877 19.4148 16.3731 19.9309 15.7618 19.6112L11.0002 17.1215L6.23851 19.6112C5.62721 19.9309 4.91266 19.4148 5.02941 18.7379L5.93856 13.4674L2.08627 9.7367C1.59165 9.25774 1.86395 8.42273 2.54714 8.32345L7.87192 7.5496Z" fill="#FFD700" stroke="#FFD700" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                      </span>
                    </label>
                  </fieldset>
                </div>
              </div>
              <div class="map_popup__form_item">
                <div class="form_input">
                  <label class="form_input__label" for="review_popup_name">Введіть своє імʼя та призвіще*</label>
                  <div class="form_input__field">
                    <input class="form_input__element" id="review_popup_name"
                           placeholder="Почніть вводити тут" />
                  </div>
                </div>
              </div>
              <div class="map_popup__form_item">
                <div class="form_textarea">
                  <label class="form_textarea__label" for="review_text">Введіть свій відгук</label>
                  <div class="form_textarea__field">
							<textarea class="form_textarea__element" id="review_text"
                        placeholder="Поділіться своїм враженням" maxlength="300"></textarea>
                  </div>
                </div>
              </div>
              <div class="map_popup__form_item map_popup__form_item--offset_mod">
                <div class="image_upload js-image-upload">
                  <div class="image_upload__field">
                    <input class="image_upload__field_input js-image-upload-input" id="review_upload_image"
                           type="file" multiple="" accept="image/png, image/jpeg, image/webp" /><label class="image_upload__field_label"
                                                            for="review_upload_image">
                      <div class="image_upload__field_label_icon">
									<span class="icon icon--size_mod" data-sprite-icon="camera">
										<svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
											<use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#camera"></use>
										</svg>
									</span>
                      </div>
                      <span>Додати фото</span>
                    </label>
                  </div>
                  <div class="image_upload__gallery js-image-upload-gallery"></div>
                </div>
              </div>
              <div class="map_popup__popup_buttons">
                <button class="btn_v3 js-map-review-back" type="button">
                  Скасувати
                </button>
                <button class="btn_v3" type="button">Опублікувати відгук</button>
              </div>
            </form>
          </div>
          <div class="map_popup__marker_info">
            <div class="map_popup__head">
              <div class="map_popup__title">Про укриття</div>
              <div class="map_popup__close js-map-popup-close">
                <span class="icon icon--size_mod" data-sprite-icon="close">
                  <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#close"></use>
                  </svg>
                </span>
              </div>
            </div>

            <div class="map_popup__rating js-map-review-add" role="button" tabindex="0">
              <ul class="stars_rating">
                <li class="stars_rating__item">
                  <span class="icon icon--size_mod" data-sprite-icon="star">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                      <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#star"></use>
                    </svg>
                  </span>
                </li>
                <li class="stars_rating__item">
                  <span class="icon icon--size_mod" data-sprite-icon="star">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                      <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#star"></use>
                    </svg>
                  </span>
                </li>
                <li class="stars_rating__item">
                  <span class="icon icon--size_mod" data-sprite-icon="star">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                      <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#star"></use>
                    </svg>
                  </span>
                </li>
                <li class="stars_rating__item">
                  <span class="icon icon--size_mod" data-sprite-icon="star-outline">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                      <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#star-outline"></use>
                    </svg>
                  </span>
                </li>
                <li class="stars_rating__item">
                  <span class="icon icon--size_mod" data-sprite-icon="star-outline">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                      <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#star-outline"></use>
                    </svg>
                  </span>
                </li>
              </ul>
              <div class="map_popup__rating_total">(111)</div>
            </div>
            <div class="map_popup__excerpt"></div>
            <div class="map_popup__info map_popup__info--v1_mod">

            </div>
            <div class="map_popup__info map_popup__info--v2_mod">

            </div>

            <!-- Gallery Section -->
            <div class="map_popup__block gallery_v1" data-gallery-section="">
              <div class="map_popup__block_title">Фото</div>
              <div class="map_popup__gallery">
                <div class="map_popup__gallery_arrow map_popup__gallery_arrow--prev_mod" data-gallery-prev-arrow="">
                  <span class="icon icon--size_mod" data-sprite-icon="chevron-right">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#chevron-right"></use>
                      </svg>
                  </span>
                </div>
                <div class="map_popup__gallery_arrow map_popup__gallery_arrow--next_mod" data-gallery-next-arrow="">
                  <span class="icon icon--size_mod" data-sprite-icon="chevron-right">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#chevron-right"></use>
                      </svg>
                  </span>
                </div>
                <div class="map_popup__gallery_list swiper" data-gallery-slider="">
                  <div class="swiper-wrapper">
                    <?php
                    $gallery_images = array('project1.webp', 'project2.webp', 'project1.webp', 'project2.webp', 'project1.webp', 'project2.webp');
                    foreach ($gallery_images as $image) :
                      ?>
                      <div class="map_popup__gallery_item swiper-slide">
                        <picture class="map_popup__gallery_image">
                          <img class="map_popup__gallery_image_el"
                               src="<?php echo $theme_uri; ?>/images/<?php echo $image; ?>"
                               alt="Content Picture"
                               loading="lazy">
                        </picture>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="map_popup__block map__reviews">
              <div class="map_popup__block_title">Відгуки</div>

              <div class="map_popup__reviews_wrap">
                <button class="map_popup__reviews_btn js-map-review-add">
                  <span class="map_popup__reviews_btn_icon">
                    <span class="icon icon--size_mod" data-sprite-icon="pencil-square">
                      <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#pencil-square"></use>
                      </svg>
                    </span>
                  </span>
                  <span class="map_popup__reviews_btn_title">Залишити відгук</span>
                  <span class="map_popup__reviews_btn_arrow">
                    <span class="icon icon--size_mod" data-sprite-icon="chevron-right">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use xlink:href="<?php echo $theme_uri; ?>/images/sprite/sprite1.svg#chevron-right"></use>
                      </svg>
                    </span>
                  </span>
                </button>


                <button class="map_popup__reviews_all" type="button">
                  Переглянути ще відгуки
                </button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <?php
  return ob_get_clean();
}

add_shortcode('shelter_map', 'shelter_map_shortcode');