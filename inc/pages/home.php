<?php

//HOMEPAGE

?>
        <!-- ### $App Screen Content ### -->
        <main class="main-content bgc-grey-100">
            <div id="mainContent">

                <?php
                switch (auth_level){
                    case 0;
                    include "home_pages/super_admin.php";
                    break;

                    case 3;
                        include "home_pages/advisor.php";
                }
                ?>



            </div>
        </main>

