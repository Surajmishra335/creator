<link href="{{ asset('creator/public/css/navbar.css') }}" rel="stylesheet">    
<!-- Sidebar  -->
<nav id="sidebar">
            <div class="sidebar-header">
                <h3>CreatorX</h3>
            </div>

            <ul class="list-unstyled components">
                <div class="line"></div>
                <li>
                    <a href="/">Home</a>
                </li>
                <div class="line"></div>
                <li>
                    <a href="/profile">My Profile</a>
                </li>
                <div class="line"></div>
                <li>
                    <a href="#">Projects</a>
                </li>
                <div class="line"></div>
                <li>
                    <a href="#">Collaborate</a>
                </li>
                <div class="line"></div>
                <li>
                    <a href="#">Settings</a>
                </li>
            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a href="" class="download">Logout</a>
                </li>
                <!-- <li>
                    <a href="" class="article">Back to article</a>
                </li> -->
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content" style="overflow:scroll">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent" style="justify-content: flex-end;">
                        <!-- profile photo -->
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <img src="https://www.w3schools.com/howto/img_avatar.png" width="30" height="30" class="rounded-circle">
                                </a>
                            </li>
                    </div>
                </div>
            </nav>
            
            @yield('content')
           
        </div>