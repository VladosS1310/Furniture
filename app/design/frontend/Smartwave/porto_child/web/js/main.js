require([
    'jquery'
], function ($) {
    $(document).ready(function () {

        // sidebar animation on mobile

        $('.sidebar .block-category-list .block-title').click(function () {
            if ($(window).width() < 768) {
                var accordion = $(this).next('.block-content');
                if ($(accordion).is(':visible')) {
                    $(this).removeClass('nav-open');
                    $(accordion).slideUp('normal');
                    return false;
                } else {
                    $('.sidebar .block-category-list .block-title').removeClass('nav-open');
                    $('.sidebar .block-category-list .block-content').slideUp('normal');
                    $(this).addClass('nav-open');
                    $(accordion).slideDown('normal');
                }
            }
        });

        $('.sidebar .block-collapsible-nav .title').click(function () {
            if ($(window).width() < 768) {
                var accordion = $(this).next('.content');
                if ($(accordion).is(':visible')) {
                    $(this).removeClass('nav-open');
                    $(accordion).slideUp('normal');
                    return false;
                } else {
                    $('.sidebar .block-collapsible-nav .title').removeClass('nav-open');
                    $('.sidebar .block-collapsible-nav .content').slideUp('normal');
                    $(this).addClass('nav-open');
                    $(accordion).slideDown('normal');
                }
            }
        });

        $(".contact-tab__details").click(function () {
            if($(window).width() > 768) return;

            $(this).next().slideToggle('slow');
            $(this).toggleClass("rotate");
        })

        $(".category__description").click(() => {
            if($(window).width() < 768) {
                $(".category__description").toggleClass("open");
            }
        })

        let text = $('.category__description h4').text();
        let btnToggle = document.createElement("span");
        btnToggle.appendChild(document.createTextNode("Read more"));
        btnToggle.className = "btn-toggle";
        let modifiedTextSliced = text.substring(0,200) + "...";
        let modifiedTextFull = text;
        let showFullText = false;
        let content = document.querySelector('.category__description h4');

        btnToggle.addEventListener('click', () => {
            if(showFullText) {
                content.innerHTML = `${modifiedTextSliced}`;
                btnToggle.textContent = "Read more";
                content.appendChild(btnToggle);
                showFullText = false;
                return;
            }
            content.innerHTML = `${modifiedTextFull}`;
            btnToggle.textContent = "Read less";
            content.appendChild(btnToggle);
            showFullText = true;
        })

        if($(window).width() > 768) {
            cutText();
        }

        $(window).on('resize load', () => {
            if($(window).width() > 750) {
                if($('.category__description h4').text().length > 200) {
                    cutText();
                }
            } else {
                $('.category__description h4').text(text);
                $('.btn-read-more').css("display", "none");
            }
        });

        function cutText() {
            content.innerHTML = `${modifiedTextSliced}`;
            btnToggle.textContent = "Read more";
            content.appendChild(btnToggle);
            showFullText = false;
        }

        const button = document.querySelector('.box-tocart .fieldset .actions');
        const buttonContainer = document.querySelector('.field.qty');

        function updateButtonPosition() {
            const buttonContainerPosition = buttonContainer.getBoundingClientRect().top + 50;
            const viewportHeight = window.innerHeight;

            if (buttonContainerPosition > viewportHeight) {
                if (!button.classList.contains('button-fixed')) {
                    button.classList.add('button-fixed');
                    button.classList.remove('button-normal');
                }
            } else {
                if (!button.classList.contains('button-normal')) {
                    button.classList.remove('button-fixed');
                    button.classList.add('button-normal');
                }
            }
        }

        window.addEventListener('scroll', updateButtonPosition);
        window.addEventListener('resize', updateButtonPosition);

        updateButtonPosition();
    });
});
