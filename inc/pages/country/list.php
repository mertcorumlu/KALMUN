<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 16:34
 */

?>

<!-- ### $App Screen Content ### -->
<main class="main-content bgc-grey-100">
    <div id="mainContent">

        <div class="container-fluid" style="padding:0;">
            <!--                    <h4 class="c-grey-900 mT-10 mB-30">Data Tables</h4>-->
            <div class="row">

                <div class="col-md-12" style="padding:0;">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <style>
                            .DataTable tr,td{
                                vertical-align: middle;
                            }
                        </style>
                        <table class="DataTable table table-striped table-bordered dataTable no-footer" cellspacing="0" cellpadding="0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Country Name</th>
                                <th>Flag / ISO Code</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            try{

                                /*
                                 * SELECT ALL COMMITTEES
                                 * JOIN THEM WITH ADVISOR NAME AND COUNTRY NAME
                                 */
                                $applications = $PDO->query("SELECT 
                                                                      *
                                                                       FROM 
                                                                       `countries` 
                                                                        ");

                                /*
                                 * DISPLAY ALL SCHOOLS
                                 */
                                while($data = $applications->fetch(PDO::FETCH_ASSOC)){


                                    ?>

                                    <tr>
                                        <td><strong><?=$data["id"]?></strong></td>
                                        <td><?=$data["country_name"]?></td>
                                        <td><div class=" <?=$data["flag"] != "" ? "flag flag-".strtolower($data["flag"]) :"" ?>" style="vertical-align: middle"></div><?=$data["flag"]?></td>




                                        <td>
                                            <button type="button" class="btn btn-primary" onclick="open_popup('/inc/ajax/country-edit?id=<?=$data["id"]?>')">Edit</button>
                                        </td>



                                    </tr>

                                    <?php
                                }
                            }catch (PDOException $e){
                                trigger_error($e->errorInfo[2],E_USER_ERROR);
                            }

                            ?>


                            </tbody>
                        </table>
                    </div>
                </div>




            </div>
        </div>

<!--        <script>-->
<!---->
<!---->
<!--            // $(document).ready( function () {-->
<!--            //     // $('.DataTable').DataTable({-->
<!--            //     //     "order":[[0,"asc"]]-->
<!--            //     // });-->
<!--            // } );-->
<!--        </script>-->

    </div>
</main>


