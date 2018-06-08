<?php

//HOMEPAGE

?>
        <!-- ### $App Screen Content ### -->
        <main class="main-content bgc-grey-100">
            <div id="mainContent">

                <?php
                switch (auth_level){
                    case "0":
                    case "1":
                        echo auth_level;

                    include "home_pages/super_admin.php";
                    break;

                    case "2":
                    include "home_pages/chair.php";
                    break;

                    case "3":
                        include "home_pages/advisor.php";
                        break;

                    case "4":
                        include "home_pages/delegate.php";
                        break;




                }
                ?>



            </div>
        </main>

