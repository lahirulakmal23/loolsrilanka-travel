// --- THEME JS --- //

const theme = {

    // THEME FUNTIONS
    init: function () {

        theme.scrollTop();
        theme.headerSticked();
        theme.headerNavbar();
        theme.changeAvatar();
        theme.aosAnimations();
        theme.countdown();
        theme.priceRange();
        theme.splideSlider();
        theme.plyrPlayer();
        theme.gLightbox();
        theme.datepicker();
        theme.dropdownSelect();
        theme.bsValidation();
        theme.preloader();

    },

    // SCROLL TO TOP 
    scrollTop: () => {

        // Select the element with the class 'scroll-top'
        const scrollTop = document.querySelector('.scroll-top');

        // If the 'scroll-top' element exists
        if (scrollTop) {

            // Function to toggle the 'active' class based on the scroll position
            const toggleScrollTop = () => scrollTop.classList.toggle('active', window.scrollY > 150);

            // Function to scroll to the top of the page smoothly
            const scrollToTop = () => window.scrollTo({ top: 0, behavior: 'smooth' });

            // Add event listener to toggle 'active' class on window load
            window.addEventListener('load', toggleScrollTop);

            // Add event listener to toggle 'active' class on document scroll
            document.addEventListener('scroll', toggleScrollTop);

            // Add event listener to scroll to the top when the 'scroll-top' element is clicked
            scrollTop.addEventListener('click', scrollToTop);

        }

    },

    // HEADER STICKED
    headerSticked: () => {

        // Select the header element with the id 'header'
        const selectHeader = document.querySelector('#header');

        // If the header element exists
        if (selectHeader) {

            // Add an event listener for the document's scroll event
            document.addEventListener('scroll', () => {

                // Check if the scroll position is greater than 130 pixels
                if (window.scrollY > 130) {
                    // Add the 'header-sticked' class to the header
                    selectHeader.classList.add('header-sticked');

                    // Check if the scroll position is greater than or equal to 300 pixels
                    if (window.scrollY >= 300) {
                        // Add the 'header-showed' class to the header
                        selectHeader.classList.add('header-showed');
                    } else {
                        // Remove the 'header-showed' class from the header
                        selectHeader.classList.remove('header-showed');
                    }
                } else {
                    // Remove the 'header-sticked' class from the header if scroll position is less than or equal to 130 pixels
                    selectHeader.classList.remove('header-sticked');
                }
            });
        }

    },

    // NAVBAR NAV
    // https://getbootstrap.com/docs/5.3/components/navbar/
    headerNavbar: () => {
        // Select all offcanvas-navbar elements and iterate through each
        document.querySelectorAll('.offcanvas.offcanvas-navbar').forEach(offcanvasNavbar => {

            let timeout;

            // Select all dropdown elements in the navbar
            const dropdowns = offcanvasNavbar.querySelectorAll('.nav-item.dropdown');
            // Select all toggle icons in the navbar
            const toggleIcons = offcanvasNavbar.querySelectorAll('.dropdown-toggle-icon');

            // Handler for mouse entering the menu
            const handleMouseEnter = (menu) => {
                if (!offcanvasNavbar.classList.contains('show')) {
                    clearTimeout(timeout); // Clear any previous timeout
                    // Hide all currently displayed dropdown menus
                    offcanvasNavbar.querySelectorAll('.dropdown-menu.show').forEach(menu => menu.classList.remove('show'));
                    // Show the current menu
                    menu.classList.add('show');
                }
            };

            // Handler for mouse leaving the menu
            const handleMouseLeave = (menu) => {
                if (!offcanvasNavbar.classList.contains('show')) {
                    // Set a timeout to hide the menu after 500ms
                    timeout = setTimeout(() => {
                        menu.classList.remove('show');
                    }, 500);
                }
            };

            // Add mouseenter and mouseleave events to the dropdown elements
            dropdowns.forEach(dropdown => {
                const toggle = dropdown.querySelector('.dropdown-toggle-hover');
                const menu = dropdown.querySelector('.dropdown-menu');

                if (toggle && menu) {
                    // Add events to both the toggle and the menu elements
                    [toggle, menu].forEach(el => {
                        el.addEventListener('mouseenter', () => handleMouseEnter(menu));
                        el.addEventListener('mouseleave', () => handleMouseLeave(menu));
                    });
                }
            });

            // Change icons when offcanvas-navbar is shown
            offcanvasNavbar.addEventListener('show.bs.offcanvas', () => {
                toggleIcons.forEach(icon => icon.classList.replace("hicon-thin-arrow-down", "hicon-plus-thin"));
            });

            // Change icons when offcanvas-navbar is hidden
            offcanvasNavbar.addEventListener('hide.bs.offcanvas', () => {
                toggleIcons.forEach(icon => {
                    icon.classList.replace("hicon-plus-thin", "hicon-thin-arrow-down");
                    icon.classList.replace("hicon-minus-thin", "hicon-thin-arrow-down");
                });
            });

            // Add click events to the toggle icons to control menu state
            toggleIcons.forEach(icon => {
                icon.addEventListener('click', function (event) {
                    if (offcanvasNavbar.classList.contains('show')) {
                        event.preventDefault(); // Prevent default click behavior
                        const parent = this.parentNode; // Parent element of the clicked icon
                        const nextSibling = parent.nextElementSibling; // Next sibling element (dropdown menu)

                        // Toggle the display state of the menu
                        parent.classList.toggle('active');
                        nextSibling.classList.toggle('show');
                        // Change the icon state
                        icon.classList.toggle('hicon-plus-thin');
                        icon.classList.toggle('hicon-minus-thin');
                    }
                });
            });
        });
    },

    // CHANGE AVATAR
    changeAvatar: () => {

        // Select all elements with the class 'user-avatar'
        const userAvatars = document.querySelectorAll('.user-avatar');

        // Iterate over each 'user-avatar' element
        userAvatars.forEach(userAvatar => {

            // Find the input element for avatar, update button, and image within the current 'user-avatar' element
            const inputAvatar = userAvatar.querySelector('.input-avatar');
            const updateAvatarBtn = userAvatar.querySelector('.btn-update-avatar');
            const showAvatarImg = userAvatar.querySelector('.show-avatar');

            // Check if all required elements are found
            if (inputAvatar && updateAvatarBtn && showAvatarImg) {

                // Add an event listener for changes on the avatar input
                inputAvatar.addEventListener('change', () => {
                    const file = inputAvatar.files && inputAvatar.files[0]; // Get the selected file

                    if (file) {
                        const fileExtension = file.name.split('.').pop().toLowerCase(); // Get the file extension
                        if (['jpg', 'gif', 'png'].includes(fileExtension)) { // Check if the file is a valid image type

                            // Show the update button if the file is valid
                            updateAvatarBtn.classList.remove('d-none');

                            const reader = new FileReader();
                            reader.onload = () => {
                                // Update the image source to the selected file's data URL
                                showAvatarImg.src = reader.result;
                                showAvatarImg.srcset = reader.result;
                            };
                            reader.readAsDataURL(file); // Read the file as a data URL
                        } else {
                            // Hide the update button if the file is not a valid image type
                            updateAvatarBtn.classList.add('d-none');
                        }
                    } else {
                        // Hide the update button if no file is selected
                        updateAvatarBtn.classList.add('d-none');
                    }
                });
            }
        });
    },

    // COUNTDOWN
    countdown: () => {

        // Select all elements with the data-date attribute and iterate over each element
        document.querySelectorAll('[data-date]').forEach(dateElement => {

            // Define basic time values
            const second = 1000,           // 1 second = 1000 milliseconds
                minute = second * 60,      // 1 minute = 60 seconds
                hour = minute * 60,        // 1 hour = 60 minutes
                day = hour * 24;           // 1 day = 24 hours

            // Get the date value from the data-date attribute of the current element
            const date = dateElement.dataset.date;
            let countDown = new Date(date).getTime();   // Calculate the countdown time in milliseconds from the current date

            // Set up the setInterval function to update the countdown every second
            let x = setInterval(function () {
                let now = new Date().getTime(),         // Get the current time in milliseconds
                    distance = countDown - now;         // Calculate the time distance from now to the countdown date

                // Find the child elements with data-days, data-hours, data-minutes, and data-seconds attributes
                const daysElement = dateElement.querySelector('[data-days]');
                const hoursElement = dateElement.querySelector('[data-hours]');
                const minutesElement = dateElement.querySelector('[data-minutes]');
                const secondsElement = dateElement.querySelector('[data-seconds]');

                // Update the remaining days if the corresponding element exists
                if (daysElement) {
                    daysElement.innerText = Math.floor(distance / day);
                }

                // Update the remaining hours if the corresponding element exists
                if (hoursElement) {
                    hoursElement.innerText = Math.floor((distance % day) / hour);
                }

                // Update the remaining minutes if the corresponding element exists
                if (minutesElement) {
                    minutesElement.innerText = Math.floor((distance % hour) / minute);
                }

                // Update the remaining seconds if the corresponding element exists
                if (secondsElement) {
                    secondsElement.innerText = Math.floor((distance % minute) / second);
                }
            }, second); // The setInterval function will run every second (1000 milliseconds)
        });

    },

    // AOS ANIMATIONS
    // https://github.com/michalsnik/aos
    aosAnimations: () => {
        AOS.init({
            delay: 350,
            duration: 1000,
            once: true,
            mirror: true,
            offset: 50,
        });
    },

    // SPLIDE SLIDER
    // https://github.com/Splidejs/splide
    splideSlider: () => {

        // Destination slider
        if (document.querySelector('.destination-slider')) {
            new Splide('.destination-slider', {
                perPage: 4,
                padding: 0,
                gap: '1.5rem',
                speed: 1000,
                type: 'loop',
                focus: 0,
                breakpoints: {
                    1400: {
                        perPage: 3,
                        padding: { left: 0, right: '180px' },
                    },
                    1200: {
                        perPage: 1,
                        padding: { left: 0, right: '280px' },
                        arrows: false,
                    },
                    992: {
                        perPage: 1,
                        padding: { left: 0, right: '250px' },
                        arrows: false,
                    },
                    576: {
                        perPage: 1,
                        gap: '0.75rem',
                        arrows: false,
                        padding: 0,
                    },
                }
            }).mount();
        }

        // Tour category slider
        if (document.querySelector('.tour-category-slider')) {
            new Splide('.tour-category-slider', {
                perPage: 5,
                padding: 0,
                gap: '1rem',
                speed: 1000,
                type: 'loop',
                focus: 0,
                breakpoints: {
                    1400: {
                        perPage: 4,
                        padding: { left: 0, right: '150px' },
                    },
                    1200: {
                        perPage: 2,
                        padding: { left: 0, right: '150px' },
                    },
                    992: {
                        perPage: 2,
                        padding: { left: 0, right: '120px' },
                    },
                    576: {
                        perPage: 1,
                        padding: { left: 0, right: '120px' },
                        gap: '0.75rem',
                        arrows: false,
                    },
                }
            }).mount();
        }

        // Tour slider
        if (document.querySelector('.tour-slider-1')) {
            new Splide('.tour-slider-1', {
                perPage: 4,
                padding: 0,
                gap: '1.5rem',
                speed: 1000,
                type: 'loop',
                focus: 0,
                breakpoints: {
                    1400: {
                        perPage: 3,
                        padding: { left: 0, right: '180px' },
                    },
                    1200: {
                        perPage: 1,
                        padding: { left: 0, right: '280px' },
                        arrows: false,
                    },
                    992: {
                        perPage: 1,
                        padding: { left: 0, right: '250px' },
                        arrows: false,
                    },
                    576: {
                        perPage: 1,
                        gap: '0.75rem',
                        arrows: false,
                        padding: 0,
                    },
                }
            }).mount();
        }

        // Tour slider
        if (document.querySelector('.tour-slider-2')) {
            new Splide('.tour-slider-2', {
                perPage: 4,
                padding: 0,
                gap: '1.5rem',
                speed: 1000,
                type: 'loop',
				autoplay  : true,
                focus: 0,
                breakpoints: {
                    1400: {
                        perPage: 3,
                        padding: { left: 0, right: '180px' },
                    },
                    1200: {
                        perPage: 1,
                        padding: { left: 0, right: '280px' },
                    },
                    992: {
                        perPage: 1,
                        padding: { left: 0, right: '250px' },
                    },
                    576: {
                        perPage: 1,
                        gap: '0.75rem',
                        arrows: false,
                        padding: 0,
                    },
                }
            }).mount();
        }

        // Other tour slider
        if (document.querySelector('.other-tour-slider')) {
            new Splide('.other-tour-slider', {
                perPage: 4,
                padding: 0,
                gap: '1.5rem',
                speed: 1000,
                type: 'loop',
                focus: 0,
                breakpoints: {
                    1400: {
                        perPage: 3,
                        padding: { left: 0, right: '180px' },
                    },
                    1200: {
                        perPage: 1,
                        padding: { left: 0, right: '280px' },
                        arrows: false,
                    },
                    992: {
                        perPage: 1,
                        padding: { left: 0, right: '250px' },
                        arrows: false,
                    },
                    576: {
                        perPage: 1,
                        gap: '0.75rem',
                        arrows: false,
                        padding: 0,
                    },
                }
            }).mount();
        }

        // Testimonials slider 1
        if (document.querySelector('.testimonials-slider-1')) {
            new Splide('.testimonials-slider-1', {
                perPage: 3,
                gap: '1.5rem',
                speed: 1000,
                focus: 0,
                type: 'loop',
                breakpoints: {
                    1400: {
                        perPage: 2,
                    },
                    1200: {
                        perPage: 1,
                        arrows: false,
                    },
                    992: {
                        perPage: 1,
                        arrows: false,
                    },
                    576: {
                        perPage: 1,
                        gap: '0.75rem',
                        arrows: false,
                    },
                }
            }).mount();
        }

        // Testimonials slider 2
        if (document.querySelector('.testimonials-slider-2')) {
            new Splide('.testimonials-slider-2', {
                perPage: 1,
                gap: '1.5rem',
                speed: 1000,
                focus: 0,
                type: 'loop',
                pagination: false,
                breakpoints: {
                    1400: {
                        perPage: 1,
                    },
                    1200: {
                        perPage: 1,
                        arrows: false,
                        pagination: true,
                    },
                    992: {
                        perPage: 1,
                        arrows: false,
                        pagination: true,
                    },
                    576: {
                        perPage: 1,
                        gap: '0.75rem',
                        arrows: false,
                        pagination: true,
                    },
                }
            }).mount();
        }

        // Testimonials slider 2
        if (document.querySelector('.testimonials-slider-3')) {
            new Splide('.testimonials-slider-3', {
                perPage: 3,
                gap: '1.5rem',
                speed: 1000,
                focus: 0,
                type: 'loop',
                arrows: false,
                breakpoints: {
                    1400: {
                        perPage: 2,
                    },
                    1200: {
                        perPage: 1,
                    },
                    992: {
                        perPage: 1,
                    },
                    576: {
                        perPage: 1,
                        gap: '0.75rem',
                    },
                }
            }).mount();
        }

        // Blog slider 1
        if (document.querySelector('.blog-slider-1')) {
            new Splide('.blog-slider-1', {
                perPage: 4,
                padding: 0,
                gap: '1.5rem',
                speed: 1000,
                type: 'loop',
                focus: 0,
                breakpoints: {
                    1400: {
                        perPage: 3,
                        padding: { left: 0, right: '180px' },
                    },
                    1200: {
                        perPage: 1,
                        padding: { left: 0, right: '280px' },
                        arrows: false,
                    },
                    992: {
                        perPage: 1,
                        padding: { left: 0, right: '250px' },
                        arrows: false,
                    },
                    576: {
                        perPage: 1,
                        gap: '0.75rem',
                        arrows: false,
                        padding: 0,
                    },
                }
            }).mount();
        }

        // Blog slider 2
        if (document.querySelector('.blog-slider-2')) {
            new Splide('.blog-slider-2', {
                perPage: 4,
                padding: 0,
                gap: '1.5rem',
                speed: 1000,
                type: 'loop',
                focus: 0,
                breakpoints: {
                    1400: {
                        perPage: 3,
                        padding: { left: 0, right: '180px' },
                    },
                    1200: {
                        perPage: 1,
                        padding: { left: 0, right: '280px' },
                    },
                    992: {
                        perPage: 1,
                        padding: { left: 0, right: '250px' },
                    },
                    576: {
                        perPage: 1,
                        gap: '0.75rem',
                        arrows: false,
                        padding: 0,
                    },
                }
            }).mount();
        }

        // Category slider
        if (document.querySelector('.category-slider')) {
            new Splide('.category-slider', {
                perPage: 5,
                gap: '1rem',
                padding: 0,
                speed: 1000,
                focus: 0,
                type: 'loop',
                pagination: false,
                breakpoints: {
                    1200: {
                        perPage: 2,
                    },
                    992: {
                        perPage: 2,
                    },
                    576: {
                        perPage: 1,
                    },
                }
            }).mount();
        }

        // Why slider
        if (document.querySelector('.why-slider')) {
            new Splide('.why-slider', {
                perPage: 4,
                gap: '1.5rem',
                speed: 1000,
                focus: 0,
                type: 'loop',
				autoplay  : true,
                arrows: false,
                breakpoints: {
                    1200: {
                        perPage: 2,
                    },
                    992: {
                        perPage: 1,
                    },
                    576: {
                        perPage: 1,
                        gap: '0.75rem',
                    },
                }
            }).mount();
        }

        // Team slider
        if (document.querySelector('.team-slider')) {
            new Splide('.team-slider', {
                perPage: 5,
                gap: '1.5rem',
                speed: 1000,
                focus: 0,
                type: 'loop',
                arrows: false,
                breakpoints: {
                    1400: {
                        perPage: 4,
                    },
                    1200: {
                        perPage: 3,
                    },
                    992: {
                        perPage: 2,
                    },
                    576: {
                        perPage: 1,
                        gap: '0.75rem',
                    },
                }
            }).mount();
        }

    },

    // PRICE RANGE
    priceRange: () => {

        // Select all range input elements within the .price-range class
        const rangeInput = document.querySelectorAll(".price-range .range-input input");

        // Select all price input elements within the .price-range class
        const priceInput = document.querySelectorAll(".price-range .price-input input");

        // Select the progress bar element within the .price-slider class
        const range = document.querySelector(".price-range .price-slider .progress");

        // Define the minimum gap between the two price values
        let priceGap = 100;

        // Add an event listener to each price input field to enforce numeric-only input
        priceInput.forEach((input) => {
            input.addEventListener("input", (e) => {
                // Replace any non-digit characters with an empty string to allow only numbers
                e.target.value = e.target.value.replace(/\D/g, '');

                // Parse the values of the two price inputs as integers
                let minPrice = parseInt(priceInput[0].value),
                    maxPrice = parseInt(priceInput[1].value);

                // Ensure the price difference is at least the specified gap and within the maximum limit
                if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
                    // If the minimum price input is being adjusted, update the corresponding range input and progress bar
                    if (e.target.className === "input-min") {
                        rangeInput[0].value = minPrice;
                        range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
                    }
                    // If the maximum price input is being adjusted, update the corresponding range input and progress bar
                    else {
                        rangeInput[1].value = maxPrice;
                        range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
                    }
                }
            });
        });

        // Add an event listener to each range input to synchronize the values with the price inputs
        rangeInput.forEach((input) => {
            input.addEventListener("input", (e) => {
                // Parse the values of the two range inputs as integers
                let minVal = parseInt(rangeInput[0].value),
                    maxVal = parseInt(rangeInput[1].value);

                // Ensure the range difference is at least the specified gap
                if (maxVal - minVal < priceGap) {
                    // If the minimum range input is being adjusted and violates the gap, correct it
                    if (e.target.className === "range-min") {
                        rangeInput[0].value = maxVal - priceGap;
                    }
                    // If the maximum range input is being adjusted and violates the gap, correct it
                    else {
                        rangeInput[1].value = minVal + priceGap;
                    }
                }
                // If the range difference is valid, update the corresponding price inputs and progress bar
                else {
                    priceInput[0].value = minVal;
                    priceInput[1].value = maxVal;
                    range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
                    range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
                }
            });
        });

    },

    // PLYR PLAYER
    // https://github.com/sampotts/plyr
    plyrPlayer: () => {
        const players = document.querySelectorAll('.video-player');
        players.forEach(player => {
            new Plyr(player);
        });
    },

    // GLIGHTBOX
    // https://github.com/biati-digital/glightbox
    // https://github.com/sampotts/plyr
    gLightbox: () => {
        // Create a new GLightbox object for elements with the '.glightbox' class
        let photoLightbox = GLightbox({
            selector: '.glightbox'
        });

        // Create a new GLightbox object for elements with the '.media-glightbox' class
        let mediaLightbox = GLightbox({
            selector: '.media-glightbox',
            touchNavigation: true,
            loop: false,
            zoomable: false,
            autoplayVideos: true,
            moreLength: 0,
            slideExtraAttributes: {
                poster: ''
            },
            plyr: {
                config: {
                    ratio: '16:9',
                    muted: false,
                    hideControls: true,
                    youtube: {
                        noCookie: false,
                        rel: 0,
                        showinfo: 0,
                        iv_load_policy: 3
                    },
                    vimeo: {
                        byline: false,
                        portrait: false,
                        title: false,
                        speed: true,
                        transparent: false
                    }
                }
            },
        });
    },

    // DATEPICKER
    // https://github.com/flatpickr/flatpickr
    datepicker: () => {

        // Tour date
        if (document.querySelector('.tour-date')) {
            new flatpickr(".tour-date", {
                allowInput: false,
                minDate: "today",
                static: true,
                position: "right center",
                wrap: true,
                disableMobile: "true",
                dateFormat: "M d Y",
            });
        }

        // Date of birth
        if (document.querySelector('.date-of-birth')) {
            new flatpickr(".date-of-birth", {
                allowInput: false,
                maxDate: "today",
                static: true,
                position: "right center",
                wrap: true,
                disableMobile: "true",
                dateFormat: "M d Y",
            });
        }

    },

    // DROPDOWN SELECT
    // https://github.com/use-bootstrap/use-bootstrap-select
    dropdownSelect: () => {
        const dropdownSelects = document.querySelectorAll('.dropdown-select');
        dropdownSelects.forEach(element => {
            new UseBootstrapSelect(element, {
                maxHeight: '15.35rem',
            });
        });
    },

    // BOOTSTRAP VALIDATION
    // https://getbootstrap.com/docs/5.3/forms/validation
    bsValidation: () => {

        // Select all forms with the class 'needs-validation' from the HTML document
        const forms = document.querySelectorAll('.needs-validation');

        // Iterate through each form and add a submit event handler
        forms.forEach(function (form) {
            form.addEventListener('submit', function (event) {
                // Check the validity of the form using HTML5 validation
                if (!form.checkValidity()) {
                    // Prevent the default behavior of the submit event if the form is invalid
                    event.preventDefault();
                    // Stop the event from propagating further
                    event.stopPropagation();
                }
                // Add the 'was-validated' class to the form to trigger validation feedback in Bootstrap
                form.classList.add('was-validated');
            }, false);
        });

    },

    // PRELOAD
    preloader: () => {

        // Select the element with id 'preloader'
        const preloader = document.querySelector('#preloader');

        // Check if the 'preloader' element exists and the document state is 'complete'
        // Then remove the 'preloader' element
        window.onload = function () {
            if (preloader && document.readyState === 'complete') {
                window.requestAnimationFrame(() => {
                    preloader.remove();
                });
            }
        };

    },

}

document.addEventListener("DOMContentLoaded", function () {
    theme.init();
});
