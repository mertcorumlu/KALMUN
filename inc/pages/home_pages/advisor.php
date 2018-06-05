<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 31/05/2018
 * Time: 12:39
 */

try{

 $count = $PDO->query("SELECT
  (SELECT COUNT(*) FROM `phpauth_users` WHERE school_id = '{$userData["advisor_school"]}' AND auth = 4 ) as advisor_students,
  (SELECT SUM(`quota`) FROM `committee_structure` WHERE school_id = '{$userData["advisor_school"]}' ) as quota,
  (SELECT COUNT(*) FROM `phpauth_users`) as total_users,
  (SELECT COUNT(*) FROM `phpauth_users` WHERE school_id = '{$userData["advisor_school"]}' AND auth = 4 AND is_amb = 1) as advisor_amb,
  (SELECT COUNT(*) FROM `countries`) as total_countries,
  (SELECT COUNT(DISTINCT country_id) FROM `committee_structure` WHERE school_id = '{$userData["advisor_school"]}' ) as advisor_countries,
  (SELECT COUNT(*) FROM `committees`) as total_committees,
  (SELECT COUNT(DISTINCT committee_id) FROM `committee_structure` WHERE school_id = '{$userData["advisor_school"]}') as advisor_committees")
     ->fetch(PDO::FETCH_ASSOC);

 $structure = $PDO->query("
                                            SELECT 
                                            committees.id AS `committee_id`,
                                            committees.committee_name,
                                            countries.id AS `country_id`,
                                            countries.country_name,
                                            countries.flag,
                                            committee_structure.quota
                                            FROM 
                                            `committee_structure` 
                                            INNER JOIN 
                                            `countries` 
                                            ON 
                                            committee_structure.country_id = countries.id 
                                            INNER JOIN 
                                            `committees` 
                                            ON 
                                            committee_structure.committee_id = committees.id 
                                            WHERE 
                                            `school_id` = '{$userData["advisor_school"]}'  "
 );


?>
<div class="row gap-20 masonry pos-r">

    <div class="masonry-ite col-12">
        <div class="bd bgc-white p-20">
            <p>
                    <h2>Welcome to K@LMUN !</h2>

                <p>K@LMUN is a system that allows our team to multitask most of the MUN requirements and facilities.</p>
            </p>
        </div>

    </div>

    <div class="masonry-item  w-100">
        <div class="row gap-20">
            <!-- #Toatl Visits ==================== -->
            <div class='col-md-3'>
                <div class="layers bd bgc-white p-20">
                    <div class="layer w-100 mB-10">
                        <h6 class="lh-1">Total Students</h6>
                    </div>
                    <div class="layer w-100">
                        <div class="peers ai-sb fxw-nw">
                            <div class="peer peer-greed">
                                <span id="sparklinedash"><p class="alert alert-success text-center"><strong><?=$count["advisor_students"]?></strong></p></span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- #Total Page Views ==================== -->
            <div class='col-md-3'>
                <div class="layers bd bgc-white p-20">
                    <div class="layer w-100 mB-10">
                        <h6 class="lh-1">Quota</h6>
                    </div>
                    <div class="layer w-100">
                        <div class="peers ai-sb fxw-nw">
                            <div class="peer peer-greed">
                                <span id="sparklinedash2"><p class="alert alert-info text-center"><strong><?=$count["quota"]?></strong></p></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- #Unique Visitors ==================== -->
            <div class='col-md-3'>
                <div class="layers bd bgc-white p-20">
                    <div class="layer w-100 mB-10">
                        <h6 class="lh-1">Need To Add</h6>
                    </div>
                    <div class="layer w-100">
                        <div class="peers ai-sb fxw-nw">
                            <div class="peer peer-greed">
                                <span id="sparklinedash3"><p class="alert alert-danger text-center"><strong><?=$count["quota"] - $count["advisor_students"]?></strong></p></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- #Bounce Rate ==================== -->
            <div class='col-md-3'>
                <div class="layers bd bgc-white p-20">
                    <div class="layer w-100 mB-10">
                        <h6 class="lh-1">Ambassadors</h6>
                    </div>
                    <div class="layer w-100">
                        <div class="peers ai-sb fxw-nw">
                            <div class="peer peer-greed">
                                <span id="sparklinedash4"><p class="alert alert-warning text-center"><strong><?=$count["advisor_amb"]?></strong></p></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="masonry-item col-12">
        <!-- #Site Visits ==================== -->
        <div class="bd bgc-white">
            <div class="peers fxw-nw@lg+ ai-s">
                <div class="peer peer-greed w-70p@lg+ w-100@lg- p-20">
                    <div class="layers">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Your Quotas</h6>
                        </div>
                        <div class="layer w-100">
                            <div id="world-map-marker">

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Committee</th>
                                        <th scope="col">Country</th>
                                        <th>Quota</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while($structure_fetch = $structure->fetch(PDO::FETCH_ASSOC)){

                                    ?>

                                        <tr>
                                            <td>
                                                <?=$structure_fetch["committee_name"]?>
                                            </td>


                                            <td>
                                                <div class=" <?=$structure_fetch["flag"] != "" ? "flag flag-".strtolower($structure_fetch["flag"]) :"" ?>" style="vertical-align: middle"></div>
                                                <?=$structure_fetch["country_name"]?>
                                            </td>


                                            <td>
                                                    <strong><?=$structure_fetch["quota"]?></strong>
                                            </td>
                                        </tr>

                                        <?php
                                    }
                                        ?>



                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="peer bdL p-20 w-30p@lg+ w-100p@lg-">
                    <div class="layers">
                        <div class="layer w-100">
                            <!-- Progress Bars -->
                            <div class="layers">
                                <br>
                                <div class="layer w-100">
                                    <small class="fw-600 c-grey-700">Users Percentage</small>
                                    <span class="pull-right c-grey-600 fsz-sm"><?=percentage($count["advisor_students"],$count["total_users"])?>%</span>
                                    <div class="progress mT-10">
                                        <div class="progress-bar bgc-deep-purple-500" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?=percentage($count["advisor_students"],$count["total_users"])?>%;"> <span class="sr-only">50% Complete</span></div>
                                    </div>
                                </div>
                                <br>
                                <div class="layer w-100 mT-15">
                                    <small class="fw-600 c-grey-700">Committee Percentage</small>
                                    <span class="pull-right c-grey-600 fsz-sm"><?=percentage($count["advisor_committees"],$count["total_committees"])?>%</span>
                                    <div class="progress mT-10">
                                        <div class="progress-bar bgc-green-500" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?=percentage($count["advisor_committees"],$count["total_committees"])?>%;"> <span class="sr-only">80% Complete</span></div>
                                    </div>
                                </div>
                                <br>
                                <div class="layer w-100 mT-15">
                                    <small class="fw-600 c-grey-700">Country Percentage</small>
                                    <span class="pull-right c-grey-600 fsz-sm"><?=percentage($count["advisor_countries"],$count["total_countries"])?>%</span>
                                    <div class="progress mT-10">
                                        <div class="progress-bar bgc-light-blue-500" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?=percentage($count["advisor_countries"],$count["total_countries"])?>%;"> <span class="sr-only">40% Complete</span></div>
                                    </div>
                                </div>
                                <br>
                                <div class="layer w-100 mT-15">
                                    <small class="fw-600 c-grey-700">Ambassador Percentage</small>
                                    <span class="pull-right c-grey-600 fsz-sm"><?=percentage($count["advisor_amb"],$count["advisor_students"])?>%</span>
                                    <div class="progress mT-10">
                                        <div class="progress-bar bgc-blue-grey-500" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?=percentage($count["advisor_amb"],$count["advisor_students"])?>%;"> <span class="sr-only">90% Complete</span></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<?php
}catch(PDOException $e){
    return_error($e->getMessage());
}
