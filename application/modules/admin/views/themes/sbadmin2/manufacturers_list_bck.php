<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
                <h2>
                    Brands
                    <a  href="<?= base_url('admin/manufacturers/create') ?>" class="btn btn-success" style="float: right" >Add a new</a>
                </h2>
            </div>
        </div><!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!--<div class="panel-heading">
                    Brands listing 
                    [{
                            <?php foreach ($sales as $key => $list) : {?>
                    name:   '<?php echo $this->manufacturer->get($list->manufacturer)->name; ?>' ,
                    data:   <?php echo $list->sales; } ?> }, {    
                            <?php endforeach; ?>
                    }]
                </div>-->
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Country</th>
                                    <th>CE Mark</th>
                                    <th>URL</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($manufacturers)): ?>
                                    <?php foreach ($manufacturers as $key => $list): ?>
                                        <tr class="odd gradeX">
                                            <td><?=$list['id']?></td>
                                            <td><?=$list['name']?></td>
                                            <td><?=$list['country']?></td>
                                            <td><?=$list['ce_mark']?></td>
                                            <td><?=$list['url']?></td>
                                            <td>
                                                <a href="<?= base_url('assets/uploads/files/documents/brands/'.$list['file']) ?>" target="_blank" class="btn btn-info">Έντυπα (ISO, CE)</a>  
                                                <a href="<?= base_url('admin/manufacturers/edit/'.$list['id']) ?>" class="btn btn-info">edit</a>  
                                                <a href="<?= base_url('admin/manufacturers/delete/'.$list['id']) ?>" class="btn btn-danger">delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr class="even gradeC">
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>
                                            <a href="#" class="btn btn-info">edit</a>  
                                            <a href="#" class="btn btn-danger">delete</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfooter>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Country</th>
                                    <th>CE Mark</th>
                                    <th>URL</th>
                                    <th>Action</th>
                                </tr>
                            </tfooter>
                        </table>
                    </div>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div>
</div><!-- /#page-wrapper --><?php //echo $service_stats ?>
<div id='chart_service'></div>
<script type="text/javascript">
    $(function () {
        var service_chart = Highcharts.chart('chart_service', {
            chart: {type: 'pie'},
            title: {text: 'Κατανομή βλαβών ανα Κατασκευαστή'},
            tooltip: {pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'},
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true
                    },
                    showInLegend: false
                }
            },
            series: [{
                        name: 'Brands', 
                        data:   [{
                            <?php foreach ($sales as $key => $list) : {?>
                    name:  '<?php echo $this->manufacturer->get($list->manufacturer)->name; ?>' ,
                    data:   <?php echo $list->sales; } ?> }, {    
                            <?php endforeach; ?>
                                }]
                    }]
        });  
    });
</script>