<?php

?>
<!-- #Left Sidebar ==================== -->
<div class="sidebar">
    <div class="sidebar-inner">
        <!-- ### $Sidebar Header ### -->
        <div class="sidebar-logo">
            <div class="peers ai-c fxw-nw">
                <div class="peer peer-greed">
                    <a class="sidebar-link td-n" href="/">
                        <div class="peers ai-c fxw-nw">
                            <div class="peer">
                                <div class="logo">
                                    <img src="/inc/img/mun_logo_small.png" alt="">
                                </div>
                            </div>
                            <div class="peer peer-greed">
                                <h5 class="lh-1 mB-0 logo-text" style="color:#72777a;text-align: center">K@LMUN</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="peer">
                    <div class="mobile-toggle sidebar-toggle">
                        <a href="" class="td-n">
                            <i class="ti-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ### $Sidebar Menu ### -->

        <ul class="sidebar-menu scrollable pos-r">

            <li class="nav-item mT-30 active">
                <a class="sidebar-link" href="/">
                <span class="icon-holder">
                  <i class="c-blue-500 fa fa-home"></i>
                </span>
                    <span class="title">Home</span>
                </a>
            </li>


            <?php
            if(is_authorized(auth_level,array(0,1))) {
                ?>
                <li class="nav-item">
                    <a class="sidebar-link" href="/applications">
                <span class="icon-holder">
                  <i class="c-blue-500 fa fa-file"></i>
                </span>
                        <span class="title">Applications</span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="c-blue-500 fa fa-user"></i>
                  </span>
                        <span class="title">Users</span>

                        <span class="arrow">
                    <i class="ti-angle-right"></i>
                  </span>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="sidebar-link" href="/users/list">List Users</a>
                            </li>
                            <li>
                                <a class="sidebar-link" href="/users/add">Add New User</a>
                            </li>

                        </ul>
                    </a>

                </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="c-blue-500 fa fa-university"></i>
                  </span>
                    <span class="title">Schools</span>

                    <span class="arrow">
                    <i class="ti-angle-right"></i>
                  </span>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="sidebar-link" href="/school/list">List Schools</a>
                        </li>
                        <li>
                            <a class="sidebar-link" href="/school/add">Add New School</a>
                        </li>

                    </ul>
                </a>

            </li>

                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="c-blue-500 fa fa-gavel"></i>
                  </span>
                        <span class="title">Committees</span>

                        <span class="arrow">
                    <i class="ti-angle-right"></i>
                  </span>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="sidebar-link" href="/committee/list">List Committees</a>
                            </li>
                            <li>
                                <a class="sidebar-link" href="/committee/add">Add New Committee</a>
                            </li>

                        </ul>
                    </a>

                </li>

                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="c-blue-500 fa fa-globe"></i>
                  </span>
                        <span class="title">Countries</span>

                        <span class="arrow">
                    <i class="ti-angle-right"></i>
                  </span>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="sidebar-link" href="/country/list">List Countries</a>
                            </li>
                            <li>
                                <a class="sidebar-link" href="/country/add">Add New Country</a>
                            </li>

                        </ul>
                    </a>

                </li>

                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="c-blue-500 fa fa-book"></i>
                  </span>
                        <span class="title">Sessions</span>

                        <span class="arrow">
                    <i class="ti-angle-right"></i>
                  </span>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="sidebar-link" href="/sessions/list">List Sessions</a>
                            </li>
                            <li>
                                <a class="sidebar-link" href="/sessions/add">Add New Session</a>
                            </li>

                        </ul>
                    </a>

                </li>

                <li class="nav-item">
                    <a class="sidebar-link" href="/files">
                <span class="icon-holder">
                  <i class="c-blue-500 fa fa-file"></i>
                </span>
                        <span class="title">Files</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="sidebar-link" href="/applications">
                <span class="icon-holder">
                  <i class="c-blue-500 fa fa-cog"></i>
                </span>
                        <span class="title">Options</span>
                    </a>
                </li>

                <?php
            }
            ?>

            <?php
            if(is_authorized(auth_level,array(2))) {
                ?>

                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="c-blue-500 fa fa-file"></i>
                  </span>
                        <span class="title">Files</span>

                        <span class="arrow">
                    <i class="ti-angle-right"></i>
                  </span>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="sidebar-link" href="/files/list">List Your Files</a>
                            </li>
                            <li>
                                <a class="sidebar-link" href="/files/add">Add New File</a>
                            </li>

                            <?php
                            if( $userData["committee_id"] == $auth->config->ga1_id ||
                                $userData["committee_id"] == $auth->config->ga3_id ||
                                $userData["committee_id"] == $auth->config->ga4_id ||
                                $userData["committee_id"] == $auth->config->ga6_id ){
                            ?>
                            <li>
                                <a class="sidebar-link" href="/files/plenary-session-resolution">Choose Plenary Session Resolution</a>
                            </li>

                            <?php
                            }
                            ?>


                        </ul>
                    </a>

                </li>

                <?php
            }
            ?>

            <?php
            if(is_authorized(auth_level,array(3))) {
                ?>

                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="c-blue-500 fa fa-user-circle"></i>
                  </span>
                        <span class="title">Students</span>

                        <span class="arrow">
                    <i class="ti-angle-right"></i>
                  </span>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="sidebar-link" href="/student/list">List Your Students</a>
                            </li>
                            <li>
                                <a class="sidebar-link" href="/student/add">Add New Student</a>
                            </li>
                            <li>
                                <a class="sidebar-link" href="/student/ambassador">Choose Ambassador</a>
                            </li>

                        </ul>
                    </a>

                </li>

                <?php
            }
            ?>





        </ul>
    </div>
</div>
