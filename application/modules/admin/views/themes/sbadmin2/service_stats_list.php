<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header"><h2>Επισκευές Εργαστηρίου</h2></div>
            <div class="users-header"></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Λίστα Επισκευών
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Manufacturer Name</th>
                                    <th>Series</th>
                                    <th>Hearing Aid Model</th>
                                    <th>Number of Repairs</th>
                                    <th>Model Count</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                <?php foreach ($services as $service): ?>
                                <tr>
                                    <td><?php echo $service['manufacturer_name']; ?></td>
                                    <td><?php echo $service['series']; ?></td>
                                    <td><?php echo $service['hearing_aid_model']; ?></td>
                                    <td><?php echo $service['number_of_repairs']; ?></td>
                                    <td><?php echo $service['model_count']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <tr class="even gradeC">
                                    <td>No data</td>
                                    <td>No data</td>
                                    <td>No data</td>
                                    <td>No data</td>
                                    <td>No data</td>                                    
                                </tr>
                               
                            </tbody>
                        </table>                        
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>
<!-- /#page-wrapper -->
