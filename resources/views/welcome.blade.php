<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PT. Sumber Setia Budi</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <!-- Styles -->
    <style>
        html,
        body {
            background: url({{ asset('assets/images/landing-bg.jpg') }}) no-repeat center center fixed;
            box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.4);
            min-height: 100%;
            background-size: cover;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .container {
            background: black;
            overflow: hidden;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
            padding: 4rem 3rem;
            border-radius: .5rem;
            flex-direction: column;
            background-color: rgba(255, 255, 255, .15);
            backdrop-filter: blur(10px);
        }

        .title {
            font-size: 84px;
        }

        .links {
            display: flex;
            animation: fadeInUp;
            animation-duration: 1s;
        }

        .links>a {
            color: white;
            font-size: .8rem;
            font-weight: bold;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .logo {
            animation: fadeInDown;
            animation-duration: 1s;
        }

        .button {
            display: flex;
            border-radius: .3rem;
            padding: .5rem .9rem;
            width: 100px;
            height: 60px;
            margin: 1rem 1.1rem;
        }

        .icon-project {
            background: url({{ asset('assets/images/project.svg') }}) no-repeat;
            background-size: 40px 40px;
            background-position: bottom 10px right 10px;
            background-color: #fcba2d;
        }

        .icon-project:hover {
            color: #FAFAFA;
            filter: brightness(110%) contrast(100%);
        }

        .icon-hrd {
            background: url({{ asset('assets/images/hrd.svg') }}) no-repeat;
            background-size: 40px 40px;
            background-position: bottom 10px right 10px;
            transition: background .5s ease, color .3s;
            background-color: #2f7af6;
        }

        .icon-hrd:hover {
            color: #FAFAFA;
            filter: brightness(110%) contrast(100%);
        }

        .icon-hse {
            background: url({{ asset('assets/images/hse.svg') }}) no-repeat;
            background-size: 40px 40px;
            background-position: bottom 10px right 10px;
            transition: background .5s ease, color .3s;
            background-color: #56db13;
        }

        .icon-hse:hover {
            filter: brightness(110%) contrast(100%);
        }

        .icon-warehouse {
            background: url({{ asset('assets/images/warehouse.svg') }}) no-repeat;
            background-size: 40px 40px;
            background-position: bottom 10px right 10px;
            transition: background .5s ease, color .3s;
            background-color: #f74c4c;
        }

        .icon-warehouse:hover {
            color: #FAFAFA;
            filter: brightness(110%) contrast(100%);
        }

        .icon-workshop {
            background: url({{ asset('assets/images/workshop.svg') }}) no-repeat;
            background-size: 40px 40px;
            background-position: bottom 10px right 10px;
            transition: background .5s ease, color .3s;
            background-color: #ff6a00;
        }

        .icon-workshop:hover {
            color: #FAFAFA;
            filter: brightness(110%) contrast(100%);
        }

        #logout:hover {
            letter-spacing: 0.8em;
            background-color: #F08C99;
        }

        #logout {
            color: white;
        }

        button {
            height: 4em;
            width: 100%;
            padding: 1.5em 1em;
            margin: 1em auto;
            background-color: #FEB1C0;
            border: none;
            border-radius: 3px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.2s cubic-bezier(.4, 0, .2, 1);
            animation: fadeInUp;
            animation-duration: 1s;
        }

        .popup-menu {
            display: inline-block;
            margin-right: auto;
            position: relative;
            animation: fadeInUp;
            animation-duration: 1s;
        }

        .popup-menu-toggle {
            color: #ffffff;
            display: inline-block;
            padding: 0.5rem;
            text-decoration: none;
        }

        .popup-menu-wrapper {
            display: none;
        }

        .popup-menu-wrapper.is-open {
            display: block;
        }

        .popup-menu-panel {
            background-color: rgba(0, 0, 0, .5);
            box-shadow: 0 3px 8px 0 rgba(0, 0, 0, 0.12);
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            min-width: 300px;
        }

        .popup-menu-list {
            list-style: none;
            margin: 0;
            padding: 0.5rem 0;
        }

        .popup-menu-item {
            padding: 0.5rem 1rem;
        }

        .popup-menu-item:hover {
            background-color: rgba(23, 89, 161, .5)
        }

        .popup-menu-item a {
            color: inherit;
            display: inline-block;
            text-decoration: none;
            width: 100%;
        }

        .popup-menu-item a:hover {
            opacity: 1;
        }

        /**************************************
 * Animation
 **************************************/

        .popup-menu-wrapper.is-open .popup-menu-panel {
            animation: fadeIn 300ms ease-in-out forwards;
        }

        .popup-menu-wrapper.is-closing .popup-menu-panel {
            animation: fadeOut 300ms ease-in-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="content flex-center bounce">
            <div>
                <img class="logo" style="width:15em; margin-bottom:40px;margin-top:20px;"
                    src="{{ asset('assets/images/ssb_logo.png') }}" alt="PT. Sumber Setia Budi ">
            </div>
            <div class="links">
                <a class="button icon-hrd" href="{{ url('hrd/home') }}"><span class=""></span>HRD</a>
                <a class="button icon-project" href="http://{{ env('APP_DOMAIN') }}/tender/home">PROJECT</a>
                <a class="button icon-hse" href="http://{{ env('APP_DOMAIN') }}/hse/home">HSE</a>
                <a class="button icon-workshop" href="http://{{ env('APP_DOMAIN') }}/workshop/home">WORKSHOP</a>
            </div>
            <div>
                <div class="popup-menu js-popup">
                    <a href="#" class="popup-menu-toggle js-popup-open">
                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M12,15.5A3.5,3.5 0 0,1 8.5,12A3.5,3.5 0 0,1 12,8.5A3.5,3.5 0 0,1 15.5,12A3.5,3.5 0 0,1 12,15.5M19.43,12.97C19.47,12.65 19.5,12.33 19.5,12C19.5,11.67 19.47,11.34 19.43,11L21.54,9.37C21.73,9.22 21.78,8.95 21.66,8.73L19.66,5.27C19.54,5.05 19.27,4.96 19.05,5.05L16.56,6.05C16.04,5.66 15.5,5.32 14.87,5.07L14.5,2.42C14.46,2.18 14.25,2 14,2H10C9.75,2 9.54,2.18 9.5,2.42L9.13,5.07C8.5,5.32 7.96,5.66 7.44,6.05L4.95,5.05C4.73,4.96 4.46,5.05 4.34,5.27L2.34,8.73C2.21,8.95 2.27,9.22 2.46,9.37L4.57,11C4.53,11.34 4.5,11.67 4.5,12C4.5,12.33 4.53,12.65 4.57,12.97L2.46,14.63C2.27,14.78 2.21,15.05 2.34,15.27L4.34,18.73C4.46,18.95 4.73,19.03 4.95,18.95L7.44,17.94C7.96,18.34 8.5,18.68 9.13,18.93L9.5,21.58C9.54,21.82 9.75,22 10,22H14C14.25,22 14.46,21.82 14.5,21.58L14.87,18.93C15.5,18.67 16.04,18.34 16.56,17.94L19.05,18.95C19.27,19.03 19.54,18.95 19.66,18.73L21.66,15.27C21.78,15.05 21.73,14.78 21.54,14.63L19.43,12.97Z" />
                        </svg>
                    </a>
                    <div class="popup-menu-wrapper js-popup-menu">
                        <div class="popup-menu-panel">
                            <span> <strong> SET AS DEFAULT</strong></span>
                            <a style="margin-left: 20px" href="#" class="popup-menu-toggle js-popup-close">
                                X
                            </a>
                            <ul class="popup-menu-list">
                                <li class="popup-menu-item">
                                    <a href="#" onclick="setDefault('hrd')">HRD</a>
                                </li>
                                <li class="popup-menu-item">
                                    <a href="#" onclick="setDefault('tender')">PROJECT</a>
                                </li>
                                <li class="popup-menu-item">
                                    <a href="#" onclick="setDefault('hse')">HSE</a>
                                </li>
                                <li class="popup-menu-item">
                                    <a href="#" onclick="setDefault('workshop')">WORKSHOP</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button id="logout" type="submit">LOG OUT</button>
                </form>
            </div>

        </div>
    </div>
    <script>
        function setDefault(module) {
            $.get('{{ route('home.set-default') }}', {
                value: module
            }, function(response) {
                if (response.status == 'ok') {
                    alert('Default app has been set!')
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            PopupMenu.init();
        });

        function PopupMenu(elem) {
            this.opener = elem.querySelector('.js-popup-open');
            this.closer = elem.querySelector('.js-popup-close');
            this.menu = elem.querySelector('.js-popup-menu');

            this.handleOpen();
            this.handleClose();
        }

        PopupMenu.prototype.handleOpen = function() {
            this.opener.addEventListener('click', this.open.bind(this));
        };

        PopupMenu.prototype.handleClose = function() {
            this.closer.addEventListener('click', this.close.bind(this));
        };

        PopupMenu.prototype.open = function() {
            this.menu.classList.add('is-open');
        };

        PopupMenu.prototype.close = function() {

            this.menu.classList.add('is-closing');

            const that = this;


            this.menu.addEventListener('animationend', function close() {

                that.menu.removeEventListener('animationend', close);
                that.menu.classList.remove('is-open');
                that.menu.classList.remove('is-closing');
            });
        };

        PopupMenu.init = function() {
            const popupMenus = document.querySelectorAll('.js-popup');
            popupMenus.forEach(elem => {
                new PopupMenu(elem);
            });
        };
    </script>
</body>

</html>
