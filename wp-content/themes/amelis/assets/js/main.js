jQuery(function($) {

  // Catch the keydown for the entire document
  $(document).keydown(function(e) {

    // Set self as the current item in focus
    var self = $(':focus'),
        // Set the form by the current item in focus
        form = self.parents('.form-page'),
        focusable;

    // Array of Indexable/Tab-able items
    focusable = form.find('input,a,select,button,textarea').filter(':visible');

    function enterKey(){
      if (e.which === 13 && !self.is('textarea')) { // [Enter] key

        // If not a regular hyperlink/button/textarea
        if ($.inArray(self, focusable) && (!self.is('a')) && (!self.is('button'))){
          // Then prevent the default [Enter] key behaviour from submitting the form
          e.preventDefault();
        } // Otherwise follow the link/button as by design, or put new line in textarea

        // Focus on the next item (either previous or next depending on shift)
        focusable.eq(focusable.index(self) + (e.shiftKey ? -1 : 1)).focus();

        return false;
      }
    }
    // We need to capture the [Shift] key and check the [Enter] key either way.
    if (e.shiftKey) { enterKey() } else { enterKey() }
  });


  $(document).ready(function(){

    // Zones Desservies
    $('#voirSurLaCarte').click(function(e)  {
      e.preventDefault();

      $('#mapModalOverlay').fadeIn('fast');
      $('#mapModalContent').fadeIn('fast');
    })

    $('#mapModalOverlay').click(function(e) {
      e.preventDefault();

      $('#mapModalOverlay').fadeOut('fast');
      $('#mapModalContent').fadeOut('fast');
    })


    // Replace characters that are not numbers
    $('#rjQkSh19YTFp8ob, #randomcp_field_name').on('keyup', function(e) {
      $(e.target).val($(e.target).val().replace(/[^\d]/g, ''))
    })


    if ( $('#useOnlyNumbers').length > 0 ) {

      $('#randomcp_field_name').keypress(function(event) {
        // console.log(event.which, isNaN(String.fromCharCode(event.which)));

        if( event.which != 8 && isNaN(String.fromCharCode(event.which))) {
            $('#useOnlyNumbers').text('Veuillez saisir des chiffres uniquement').show();
        } else {
            $('#useOnlyNumbers').text('').hide();
        }
      });

    }






    // Headroom
    // $("header").headroom();

    // Trouver dropdown
    $('#agency_selection_map, #agency_selection, #agency_selection_xs, #code_postal_hidden').on('change', function(e) {
      var postal_code = $(this).val();

      var data = {
        action: 'getAgenceByPostalCode',
        postal_code: postal_code
      };

      var redirectToAgence=  $(this).hasClass('redirectToAgence');

      $.post(ajax_object.url, data, function(response_data) {

        var response = jQuery.parseJSON(response_data);

        // console.log(response_data);

        if ( response.agence == 'true') {

          if ( redirectToAgence ) {
            window.location.href = response.agence_url;
            return false;
          }

          // Trouver page stuff
          $('.map-holder').slideUp(0, function() {

            if ( $('#agenceFoundHolder').is(":visible") )
              $('#agenceFoundHolder').hide().fadeIn();
            else
              $('#agenceFoundHolder').show();

            $('#nothing-to-show').hide();

            $('.agency-entity__name').text(response.agence_post.post_title);
            $("a.agency-entity__name").attr("href", response.agence_post.url);
            $('#agenceFoundHolder').find('.btn').attr('href', response.agence_post.url);

            if ( $('#map-small').length > 0 ) {
                var mapOptions = {
                      // How zoomed in you want the map to start at (always required)
                      zoom: 17,

                      // The latitude and longitude to center the map (always required)
                      center: new google.maps.LatLng(response.data.latitude, response.data.longitude),

                      // How you would like to style the map.
                      // This is where you would paste any style found on Snazzy Maps.
                      styles: [{"featureType":"administrative.locality","elementType":"all","stylers":[{"hue":"#2c2e33"},{"saturation":7},{"lightness":19},{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":-2},{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#e9ebed"},{"saturation":-90},{"lightness":-8},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":10},{"lightness":69},{"visibility":"on"}]},{"featureType":"water","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":-78},{"lightness":67},{"visibility":"simplified"}]}]
                  };

                  // Get the HTML DOM element that will contain your map
                  // We are using a div with id="map" seen below in the <body>
                  var mapElement = document.getElementById('map-small');

                  // Create the Google Map using our element and options defined above
                  var map = new google.maps.Map(mapElement, mapOptions);

                  // Let's also add a marker while we're at it
                  var image = '/wp-content/themes/amelis/assets/images/agency.png';

                  var contentString = '<div id="content" class="map-popup">'+
                  '<div>'+
                  '</div>'+
                  '<h4 class="firstHeading"><a href="'+ response.agence_post.url +'">' + response.agence_post.post_title + '</a></h1>'+
                  '<div id="bodyContent">'+
                  '<p><strong>' + response.data.director.position + '</strong> ' + response.data.director.name + '</p>'+
                  '<p><img src="/wp-content/themes/amelis/assets/images/phone.svg" alt=""><a href="tel:' + response.data.phone_formatted + '"><span>' + response.data.phone + '</a></p>'+
                  '<p><img src="/wp-content/themes/amelis/assets/images/mail.svg" alt=""><a href="mailto:' + response.data.email + '"><span>' + response.data.email + '</a></p>'+
                  '</div>'+
                  '</div>';

                  var infowindow = new google.maps.InfoWindow();


                  // console.log(response);

                  var marker = new google.maps.Marker({
                      position: new google.maps.LatLng(response.data.latitude, response.data.longitude),
                      map: map,
                      icon: image,
                      title: response.agence_post.post_title
                  });

                  marker.addListener('click', function() {
                    infowindow.setContent(contentString);
                    infowindow.open(map, marker);
                });
            }

          });


          // Shortcode map stuff
          if ( $('#shortcode-map').length > 0 ) {
            var agence = [];

            agence.id = response.agence_post.ID;
            agence.url = response.agence_post.url;
            agence.title = response.agence_post.post_title;
            agence.director = [];
            agence.director.position = response.data.director.position;
            agence.director.name = response.data.director.name;
            agence.phone_formatted = response.data.phone_formatted;
            agence.phone = response.data.phone;
            agence.email = response.data.email;
            agence.latitude = response.data.latitude;
            agence.longitude = response.data.longitude;

            deleteMarkers(agence);
          }
        } else {

          $('#agenceFoundHolder').slideUp('fast', function() {
            $('#trouverTitle').text('Amelis sur la carte');
            $('.map-holder').slideDown('normal');
          });


          // $('.map-holder').slideUp('normal', function() {
          //   $('#nothing-to-show').text("Sorry, but we didn't find any agency for this zip code.")
          // });
        }

      }).fail(function(xhr, textStatus, e) {
      });

    })


    // Disable scroll wheel on numbers
    $('input[type=number]').on('focus', function (e) {
      $(this).on('mousewheel.disableScroll', function (e) {
        e.preventDefault()
      })
    })
    $('input[type=number]').on('blur', function (e) {
      $(this).off('mousewheel.disableScroll')
    })



    // Responsive Navigation
    $(".mobile-toggle").click(function(e) {
      e.preventDefault();
      $(".navigation").toggleClass("navigation-open");
      $(".site-overlay").toggleClass("active");
    });

    $(".search-mobile.toggle").click(function (e) {
      e.preventDefault();
      $(".nav-search-input").toggleClass("expanded");
      $(".site-overlay__undernav").toggleClass("active");
      $(".nav-search-input__field").focus();
    });

    $("#nav-search-input__form").keydown(function(e) {
      var key = e.which;
      if (key == 13) {
        // As ASCII code for ENTER key is "13"
        $("#nav-search-input__form").submit(); // Submit form code
      }
    });

    $("#nav-search-input__search-container").keydown(function (e) {
      var key = e.which;
      if (key == 13) {
        // As ASCII code for ENTER key is "13"
        $("#nav-search-input__search-container").submit(); // Submit form code
      }
    });

    $("#nav-search-input__search-container-2").keydown(function (e) {
      var key = e.which;
      if (key == 13) {
        // As ASCII code for ENTER key is "13"
        $("#nav-search-input__search-container-2").submit(); // Submit form code
      }
    });


    // $('.site-overlay').click(function(e) {
    //   e.preventDefault();
    //   $('.navigation').toggleClass('navigation-open');
    //   $('.site-overlay').toggleClass('active');
    // })


    // Responsive nav (dropdowns)
    $('li.dropdown').find('ul.dropdown-menu').wrap('<div class="dropdown-wrapper inactive" />');
    $('.dropdown-toggle').on('click', function(e) {
      e.preventDefault();

      var menuToToggle = $(this).parent().find('.dropdown-wrapper');

      if (menuToToggle.hasClass('active')) {
        $(this).removeClass('opened'); // remove arrow

        menuToToggle.removeClass('active').addClass('inactive');
      } else if (menuToToggle.hasClass('inactive')) {

        $('nav a.dropdown-toggle').removeClass('opened'); // remove all arrows
        $(this).addClass('opened'); // add arrow

        $('.dropdown-wrapper.active').removeClass('active').addClass('inactive');
        menuToToggle.removeClass('inactive').addClass('active');
      }
    });

    // Check if the browser has mouse over or not.
    function watchForHover() {
        var hasHoverClass = false;
        var container = document.body;
        var lastTouchTime = 0;

        function enableHover() {
            // filter emulated events coming from touch events
            if (new Date() - lastTouchTime < 500) return;
            if (hasHoverClass) return;

            container.className += ' hasHover';
            hasHoverClass = true;
        }

        function disableHover() {
            if (!hasHoverClass) return;

            container.className = container.className.replace(' hasHover', '');
            hasHoverClass = false;
        }

        function updateLastTouchTime() {
            lastTouchTime = new Date();
        }

        document.addEventListener('touchstart', updateLastTouchTime, true);
        document.addEventListener('touchstart', disableHover, true);
        document.addEventListener('mousemove', enableHover, true);

        enableHover();
    }

    watchForHover();



    // $('#amelis_tph_field').on('keydown', function(e) {
    //     var numbersOnly = parseInt($(this).val().match(/\d+/gi).join('') );
    //     $(this).val(numbersOnly);
    // })

    // Smooth scroll
    $('a.scroll').bind('click',function(event){
      var $anchor = $(this);
      $('html, body').stop().animate({
        scrollTop: ( $($anchor.attr('href')).offset().top - 40 )
      }, 1000);
      event.preventDefault();
      return false;
    });

    $('.inputfile').each(function () {
      var $input = $(this),
        $label = $input.next('label'),
        labelVal = $label.html();

      $input.on('change', function (e) {
        var fileName = '';

        if (this.files && this.files.length > 1)
          fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
        else if (e.target.value)
          fileName = e.target.value.split('\\').pop();

        if (fileName)
          $label.find('span').html(fileName);
        else
          $label.html(labelVal);
      });

      // Firefox bug fix
      $input
        .on('focus', function () { $input.addClass('has-focus'); })
        .on('blur', function () { $input.removeClass('has-focus'); });
    });

    $(".toggle-zones").click(function (e) {
      var zones = $(".zones");
      zones.toggle();
    });

    $(".functionnement-items").owlCarousel({
      margin: 0,
      mouseDrag: false,
      slideBy: 4,
      nav: true,
      navText: [
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1L1 11.0305805 10.93902554 21"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 21l10-10.0305805L1.06097446 1"/></svg>'
      ],
      responsive: {
        0: {
          items: 2
        },
        600: {
          items: 2
        },
        1000: {
          dots: false,
          nav: false,
          items: 4
        }
      }
    });

    $(".financement-items").owlCarousel({
      margin: 0,
      mouseDrag: false,
      nav: true,
      navText: [
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1L1 11.0305805 10.93902554 21"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 21l10-10.0305805L1.06097446 1"/></svg>'
      ],
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          dots: false,
          items: 3,
          nav: false
        }
      }
    });

    $(".financement-items .elementor-row").owlCarousel({
      margin: 0,
      mouseDrag: false,
      nav: true,
      navText: [
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1L1 11.0305805 10.93902554 21"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 21l10-10.0305805L1.06097446 1"/></svg>'
      ],
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          dots: false,
          items: 3,
          nav: false
        }
      }
    });

    $(".apa-slide-2-items").owlCarousel({
      margin: 0,
      mouseDrag: false,
      nav: true,
      navText: [
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1L1 11.0305805 10.93902554 21"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 21l10-10.0305805L1.06097446 1"/></svg>'
      ],
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          dots: false,
          items: 4,
          nav: false
        }
      }
    });

    $(".member-carousel").owlCarousel({
      margin: 0,
      mouseDrag: false,
      nav: true,
      navText: [
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1L1 11.0305805 10.93902554 21"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 21l10-10.0305805L1.06097446 1"/></svg>'
      ],
      responsive: {
        0: {
          items: 2,
          dotsEach: 2
        },
        600: {
          items: 2,
          dotsEach: 2
        },
        1000: {
          dots: true,
          dotsEach: 3,
          items: 3,
          nav: true
        }
      }
    });

    $(".prestation-holder").owlCarousel({
      margin: 0,
      mouseDrag: false,
      slideBy: 2,
      nav: true,
      navText: [
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1L1 11.0305805 10.93902554 21"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 21l10-10.0305805L1.06097446 1"/></svg>'
      ],
      responsive: {
        0: {
          dotsEach: 2,
          items: 2
        },
        600: {
          dotsEach: 2,
          items: 2
        },
        1000: {
          dots: false,
          nav: false,
          items: 6
        }
      }
    });

    $(".prestation-holder-7").owlCarousel({
      margin: 0,
      mouseDrag: false,
      slideBy: 2,
      nav: true,
      navText: [
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1L1 11.0305805 10.93902554 21"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 21l10-10.0305805L1.06097446 1"/></svg>'
      ],
      responsive: {
        0: {
          dotsEach: 2,
          items: 2
        },
        600: {
          dotsEach: 2,
          items: 2
        },
        1000: {
          dots: false,
          nav: false,
          items: 7
        }
      }
    });

    var service_count = $(".services-carousel").children().length;

    $(".services-carousel").owlCarousel({
      margin: 0,
      mouseDrag: false,
      slideBy: 2,
      nav: true,
      navText: [
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1L1 11.0305805 10.93902554 21"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 21l10-10.0305805L1.06097446 1"/></svg>'
      ],
      responsive: {
        0: {
          dotsEach: 2,
          items: 2
        },
        600: {
          dotsEach: 2,
          items: 2
        },
        1000: {
          dots: false,
          nav: false,
          items: service_count
        }
      }
    });

    var carousel_items = $(".default-carousel .elementor-row").children().length;

    $(".default-carousel .elementor-row").owlCarousel({
      margin: 0,
      mouseDrag: false,
      slideBy: 1,
      nav: true,
      navText: [
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1L1 11.0305805 10.93902554 21"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 21l10-10.0305805L1.06097446 1"/></svg>'
      ],
      responsive: {
        0: {
          dotsEach: 1,
          items: 1
        },
        600: {
          dotsEach: 1,
          items: 3
        },
        1000: {
          dots: false,
          nav: false,
          items: carousel_items
        }
      }
    });

    var carousel_items2 = $(".default-carousel2 .elementor-row").children().length;

    $(".default-carousel2 .elementor-row").owlCarousel({
      margin: 0,
      mouseDrag: false,
      slideBy: 1,
      nav: true,
      navText: [
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1L1 11.0305805 10.93902554 21"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 21l10-10.0305805L1.06097446 1"/></svg>'
      ],
      responsive: {
        0: {
          dotsEach: 1,
          items: 1
        },
        600: {
          dotsEach: 1,
          items: 3
        },
        1000: {
          dots: false,
          nav: false,
          items: carousel_items2
        }
      }
    });

    var carousel_items3 = $(".default-carousel3 .elementor-row").children().length;

    $(".default-carousel3 .elementor-row").owlCarousel({
      margin: 0,
      mouseDrag: false,
      slideBy: 1,
      nav: true,
      navText: [
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1L1 11.0305805 10.93902554 21"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 21l10-10.0305805L1.06097446 1"/></svg>'
      ],
      responsive: {
        0: {
          dotsEach: 1,
          items: 1
        },
        600: {
          dotsEach: 1,
          items: 3
        },
        1000: {
          dots: false,
          nav: false,
          items: carousel_items3
        }
      }
    });


    $(".icons-3 .elementor-row").owlCarousel({
      margin: 0,
      mouseDrag: false,
      slideBy: 1,
      nav: true,
      navText: [
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1L1 11.0305805 10.93902554 21"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 21l10-10.0305805L1.06097446 1"/></svg>'
      ],
      responsive: {
        0: {
          dotsEach: 1,
          items: 1
        },
        600: {
          dotsEach: 1,
          items: 1
        },
        1000: {
          dots: false,
          nav: false,
          items: 3
        }
      }
    });



    $(".blog-carousel").owlCarousel({
      margin: 0,
      mouseDrag: false,
      nav: true,
      navText: [
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1L1 11.0305805 10.93902554 21"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 21l10-10.0305805L1.06097446 1"/></svg>'
      ],
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 3
        },
        1000: {
          dots: false,
          nav: false,
          items: 3
        }
      }
    });

    $(".testimonials-carousel").owlCarousel({
      margin: 0,
      mouseDrag: false,
      nav: true,
      navText: [
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1L1 11.0305805 10.93902554 21"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 21l10-10.0305805L1.06097446 1"/></svg>'
      ],
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          dots: false,
          items: 2,
          nav: false
        }
      }
    });

    $(".testimonials-carousel-single").owlCarousel({
      margin: 0,
      mouseDrag: false,
      nav: true,
      autoplay: true,
      loop: true,
      autoplayTimeout: 12000,
      navText: [
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1L1 11.0305805 10.93902554 21"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 21l10-10.0305805L1.06097446 1"/></svg>'
      ],
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 1
        },
        1000: {
          dots: true,
          items: 1,
          nav: true
        }
      }
    });

    $(".video-carousel").owlCarousel({
      items: 1,
      margin: 20,
      mouseDrag: false,
      nav: true,
      navText: [
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1L1 11.0305805 10.93902554 21"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="22"><path fill="none" fill-rule="evenodd" stroke="#4B4B4B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 21l10-10.0305805L1.06097446 1"/></svg>'
      ],
      video: true,
      videoHeight: 300,
      videoWidth: 340,
      responsive: {
        0: {
          items: 1,
          dotsEach: 1,
          slideBy: 1
        },
        600: {
          items: 2,
          dotsEach: 2,
          slideBy: 2
        },
        1000: {
          items: 3,
          dotsEach: 3,
          slideBy: 3
        }
      }
    });


    $(".services-item-clickable").click(function () {
      window.location = $(this).find("a").attr("href");
      return false;
    });

    $(".item-clickable-external").click(function () {
      window.open($(this).find("a").attr("href"), "_blank");
      return false;
    });


    $('.navbar-nav .dropdown > a').click(function () {
      location.href = this.href;
    });

  });

  (function () {

    var youtube = document.querySelectorAll(".youtube");

    for (var i = 0; i < youtube.length; i++) {

      var source = "https://img.youtube.com/vi/" + youtube[i].dataset.embed + "/sddefault.jpg";

      var image = new Image();
      image.src = source;
      image.addEventListener("load", function () {
        youtube[i].appendChild(image);
      }(i));

      youtube[i].addEventListener("click", function () {

        var iframe = document.createElement("iframe");

        iframe.setAttribute("frameborder", "0");
        iframe.setAttribute("allowfullscreen", "");
        iframe.setAttribute("src", "https://www.youtube.com/embed/" + this.dataset.embed + "?rel=0&showinfo=0&autoplay=1");

        this.innerHTML = "";
        this.appendChild(iframe);
      });
    };

  })();

})
