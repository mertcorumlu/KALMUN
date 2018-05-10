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
                                <h5 class="lh-1 mB-0 logo-text">K@LMUN</h5>
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
                  <i class="c-blue-500 ti-home"></i>
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
                  <i class="c-blue-500 ti-files"></i>
                </span>
                        <span class="title">Applications</span>
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

                <?php
            }
            ?>

        </ul>
    </div>
</div>
