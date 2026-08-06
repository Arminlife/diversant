var map;

function initial() {

    var coordinates = {lat: 49.105981457143, lng: 31.123369564286}, // Координаты центра карты

    // создаем карту и настраеваем
    map = new google.maps.Map(document.getElementById('institution-map'), {
        center: coordinates,
        zoom: 6, // определяет первоначальный масштаб
        disableDefaultUI: false, // убирает элементы управления
        scrollwheel: false, // отключает масштабирование колесиком мыши (бывает полезно, если карта на всю ширину страницы и перебивает прокрутку вниз).
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: [
		    {
		        "featureType": "administrative",
		        "elementType": "all",
		        "stylers": [
		            {
		                "visibility": "on"
		            },
		            {
		                "saturation": -100
		            },
		            {
		                "lightness": 20
		            }
		        ]
		    },
		    {
		        "featureType": "road",
		        "elementType": "all",
		        "stylers": [
		            {
		                "visibility": "on"
		            },
		            {
		                "saturation": -100
		            },
		            {
		                "lightness": 40
		            }
		        ]
		    },
		    {
		        "featureType": "water",
		        "elementType": "all",
		        "stylers": [
		            {
		                "visibility": "on"
		            },
		            {
		                "saturation": -10
		            },
		            {
		                "lightness": 30
		            }
		        ]
		    },
		    {
		        "featureType": "landscape.man_made",
		        "elementType": "all",
		        "stylers": [
		            {
		                "visibility": "simplified"
		            },
		            {
		                "saturation": -60
		            },
		            {
		                "lightness": 10
		            }
		        ]
		    },
		    {
		        "featureType": "landscape.natural",
		        "elementType": "all",
		        "stylers": [
		            {
		                "visibility": "simplified"
		            },
		            {
		                "saturation": -60
		            },
		            {
		                "lightness": 60
		            }
		        ]
		    },
		    {
		        "featureType": "poi",
		        "elementType": "all",
		        "stylers": [
		            {
		                "visibility": "off"
		            },
		            {
		                "saturation": -100
		            },
		            {
		                "lightness": 60
		            }
		        ]
		    },
		    {
		        "featureType": "transit",
		        "elementType": "all",
		        "stylers": [
		            {
		                "visibility": "off"
		            },
		            {
		                "saturation": -100
		            },
		            {
		                "lightness": 60
		            }
		        ]
		    }
		]
    });

    markers = [];
    var infowindow = new google.maps.InfoWindow();

    var institution = {};

	var institutionType = {
		"all" : {
			"count" : 0,
			"num-all": 0,
			"num-prisoners": 0
		},
		"slidchyy_izolyator" : {
			"name": "slidchyy_izolyator",
			"num-all": 0,
			"num-prisoners": 0,
			"count" : 0
		},
		"vypravna_koloniya" : {
			"name": "vypravna_koloniya",
			"num-all": 0,
			"num-prisoners": 0,
			"count" : 0
		},
		"vykhovna_koloniya" : {
			"name": "vykhovna_koloniya",
			"num-all": 0,
			"num-prisoners": 0,
			"count" : 0
		},
		"vykonannya_pokaran" : {
			"name": "vykonannya_pokaran",
			"num-all": 0,
			"num-prisoners": 0,
			"count" : 0
		},
		"vypravnyy_tsentr" : {
			"name": "vypravnyy_tsentr",
			"num-all": 0,
			"num-prisoners": 0,
			"count" : 0
		},
		"likuvalnyy_zaklad" : {
			"name": "likuvalnyy_zaklad",
			"num-all": 0,
			"num-prisoners": 0,
			"count" : 0
		}
	};
	var host = window.location.protocol + "//" + window.location.hostname;
    jQuery.getJSON(host + '/wp-content/themes/slidstvo.info/convertcsv.json', function(json){
		institution = json;

		for(let i = 0; i < institution.length; i++) {
	        addMarker(institution[i]);

	        institutionType[institution[i]['type']]["num-all"] += institution[i]["num-all"];
	        institutionType[institution[i]['type']]["num-prisoners"] += institution[i]["num-prisoners"];
	        institutionType[institution[i]['type']]["count"] += 1;
	        institutionType['all']["num-all"] += institution[i]["num-all"];
	        institutionType['all']["num-prisoners"] += institution[i]["num-prisoners"];
	        institutionType['all']["count"] += 1;
	    }
	    allCounts();
	});

	function addMarker(prop) {
		let sep = '|';
		let markerCoord = prop.coords.split(sep);
		let markerUrl = '',
			markerUrlHover = '';
		let stories = investigationsArr[prop['id']];

		if (stories) {
	    	markerUrl = window.location.origin + '/wp-content/themes/slidstvo.info/img/map/'+ prop.type +'_marker_man.svg';
	    	markerUrlHover = window.location.origin + '/wp-content/themes/slidstvo.info/img/map/'+ prop.type +'_marker_man_hover.svg';
        } else {
        	markerUrl = window.location.origin + '/wp-content/themes/slidstvo.info/img/map/'+ prop.type +'_marker.svg';
	    	markerUrlHover = window.location.origin + '/wp-content/themes/slidstvo.info/img/map/'+ prop.type +'_marker_hover.svg';
        }

	    let marker = new google.maps.Marker({
	        position: new google.maps.LatLng(markerCoord[0], markerCoord[1]),
	        map: map,
	        icon: {
	        	url: markerUrl,
	        },
	        title: prop.title,
	    });

	    let storiesString = '';

	    if (stories) {
	    	storiesString += '<div class="map-iw-stories"><span>ІСТОРІЯ З-ЗА ҐРАТ</span>'
	    	for (let i = 0; i < stories.length; i++) {
	    		storiesString += '<a href="'+stories[i]+'" class="map-iw-stories-link" target="_blank"><svg class="map-stories-icon"><use xlink:href="#map-stories-icon"></use></svg></a>';
	    	}
        	storiesString += '</div';
        }

	    let contentString = '<div id="content">'+
	        '<div id="siteNotice">'+
	        '</div>'+
	        '<div id="bodyContent">'+
	        	'<button id="button-iw-close" class="map-iw-close"><svg class="map-iw-close-icon"><use xlink:href="#map-info-window-close"></use></svg></button>'+
	        	(prop['not-controlled'] == 1 ? '<div class="map-iw-not-controlled">Не контролюється Україною</div>' : '')+
		        '<div class="map-iw-title">'+prop.title+'</div>'+
		        (prop['security-level'] != null ? '<div class="map-iw-security-level">Рівень безпеки - <span>'+prop['security-level']+'</span></div>' : '')+
		        (prop['num-prisoners'] != 0 ? '<div class="map-iw-percentage">Наповненість - <span>'+prop['percentage']+'% ('+prop['num-prisoners']+' з '+prop['num-all']+' чол.)</span></div>' : '<div class="map-iw-percentage">Дані про наповненість закладу відсутні</div>')+
		        storiesString+
	        '</div>'+
	        '</div>';

	    marker.addListener('mouseover', function() {
		    marker.setIcon(markerUrlHover);
		});
		marker.addListener('mouseout', function() {
		    marker.setIcon(markerUrl);
		});
		marker.addListener('click', function() {
			infowindow.setContent(contentString);
          	infowindow.open(map, this);
          	// marker.setIcon(markerUrlHover);
        });
        google.maps.event.addListener(infowindow, 'domready', function() {
		    var closeBtn = jQuery('#button-iw-close').get();
		    google.maps.event.addDomListener(closeBtn[0], 'click', function() {
		        infowindow.close();
		    });
		});

	    markers.push(marker);
	}

	let fiiterItem = jQuery('.map-filters-item'),
		filterAllItems = jQuery('.map-filters-item.all-filter'),
		showMarkersArr = [],
		countInstitution = jQuery('.institution-counter_count'),
		countPrisoners = jQuery('.institution-counter_prisoners'),
		countPercentage = jQuery('.institution-counter_percentage #pinkcircle');

	function allCounts() {
		countInstitution.html(institutionType['all']['count']);
		countPrisoners.html((institutionType['all']['num-prisoners']).toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
		let avgPercent = Math.round((institutionType['all']['num-prisoners']/institutionType['all']['num-all'])*100);
		countPercentage.attr("data-percent", avgPercent);
		changeCircle(avgPercent);
	}
	function selectCounts(type) {
		var sumInstitution = 0;
		var sumPrisoners = 0;
		var sumPercentage = 0;
		var sumAll = 0;

		for (let i = 0; i < type.length; i++) {
			sumInstitution += institutionType[type[i]]['count'];
		  	sumPrisoners += institutionType[type[i]]['num-prisoners'];
		  	sumAll += institutionType[type[i]]['num-all'];
		}

		countInstitution.html(sumInstitution);
		countPrisoners.html(sumPrisoners.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
		let avgPercent = Math.round((sumPrisoners/sumAll)*100);
		countPercentage.attr("data-percent", avgPercent);
		changeCircle(avgPercent);
	}

	function changeCircle(text){
	    jQuery("#pinkcircle").percircle({text:''});
	    jQuery("#pinkcircle").percircle({
	        text: text,
	        progressBarColor: '#B9463C',
	    });
	}

	function showMarkers(type) {
        for (let i=0; i< institution.length; i++) {
            if (type.indexOf(institution[i]['type']) != -1 ) {
                markers[i].setVisible(true);
            }
        }
    }
    function hideMarkers(type) {
        for (let i=0; i< institution.length; i++) {
            if (institution[i]['type'] === type) {
                markers[i].setVisible(false);
            }
        }
    }

    function toogleMarkers(toogle = false) {
        for (let i=0; i<institution.length; i++) {
            markers[i].setVisible(toogle);
        }
    }

    (function($) {
        fiiterItem.on('click', function(e) {
            let type = jQuery(this).attr('data-type');
            if(type !== ''){
            	toogleMarkers();
            	if (jQuery(this).hasClass('active')) {
            		hideMarkers(type);
            		showMarkersArr = showMarkersArr.filter(val => val !== type);
            		showMarkers(showMarkersArr);
            		selectCounts(showMarkersArr);
            	} else {
            		showMarkersArr.push(type);
            		showMarkers(showMarkersArr);
            		selectCounts(showMarkersArr);
            	}
                jQuery(this).toggleClass('active');
        		filterAllItems.removeClass('active');
            } else {
                toogleMarkers(true);
                fiiterItem.removeClass('active');
    			jQuery(this).addClass('active');
    			showMarkersArr = [];
    			allCounts();
            }

            if(!fiiterItem.is('.active')) {
		    	filterAllItems.addClass('active');
		    	toogleMarkers(true);
		    	showMarkersArr = [];
		    	allCounts();
		    }
        });

    })(jQuery);
}
