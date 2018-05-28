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
                        <table class="DataTable table table-striped table-bordered dataTable no-footer display responsive no-wrap" cellspacing="0" cellpadding="0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Committee Name</th>
                                <th>Action</th>
                                <th></th>

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
                                                                       `committees` 
                                                                        ");

                                /*
                                 * DISPLAY ALL SCHOOLS
                                 */
                                while($data = $applications->fetch(PDO::FETCH_ASSOC)){


                                    ?>

                                    <tr>
                                        <td><strong><?=$data["id"]?></strong></td>
                                        <td><?=$data["committee_name"]?></td>



                                        <td>
                                            <button type="button" class="btn btn-primary" onclick="open_popup('/inc/ajax/committee-edit?id=<?=$data["id"]?>')">Edit</button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger delete-button" data-type="committee" data-id="<?=$data["id"]?>" >Delete</button>
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

        <script>


            $(document).ready( function () {
                $('.DataTable').DataTable({
                    "order":[[1,"asc"]]
                });
            } );
        </script>

    </div>
</main>


