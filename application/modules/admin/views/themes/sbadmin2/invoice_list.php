<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
                <h2>
                    <?php echo $title ?>                    
                </h2>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Τιμολόγια</div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Έτος</th>
                                    <th>Μήνας</th>
                                    <th>Ποσό</th>
                                    <td>Rebate</td>
                                    <td>Πληρωτέο</td>
                                    <th>Κατάστημα</th>  
                                    <th>Ενέργειες</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php                                                                      
                                    if (count($invoices)):                                       
                                        foreach ($invoices as $key => $list):
                                        $selling_point = $this->selling_point->get($list['selling_point']);
                                    
                                    //rebate calculation
                                    $rebate = 0;
                                    $clear = $list['price']/1.13;
                                    if ($clear<=1000):
                                        $rebate = 0;
                                        elseif ($clear>1000 && $clear<=3000):
                                        $rebate =   ($clear-1000)*0.02;
                                        elseif ($clear>3000 && $clear<=5000) :
                                        $rebate =   (($clear-3000)*0.03) + 40;
                                        elseif ($clear>5000 && $clear<=20000) :
                                        $rebate =   (($clear-5000)*0.04) + 100;
                                        elseif ($clear>20000) :
                                        $rebate =   (($clear-20000)*0.05) + 600;                                          
                                    endif;
                                    $final_price = ($clear-$rebate)*1.13;
                                    
                                    setlocale(LC_TIME, 'el_GR.UTF-8');                                              
                                    ?>
                                        <tr class="odd gradeX">                                            
                                            <td><?= $list['year'] ?></td>
                                            <td><?= strftime('%B', mktime(0, 0, 0, $list['month'])); ?></td>
                                            <td><?= $list['price']?></td>
                                            <td><?= $rebate?></td>
                                            <td><?= $final_price ?></td>
                                            <td><?= $selling_point->city ?></td>
                                            <td style="width: 100px">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Ενέργειες
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">                                                                                                    
                                                        <a href="<?= base_url('admin/stocks/eggyisi_doc/' . $list['id']) ?>" class="btn btn-success">Εγγύηση</a><br>                                                                                                                  
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div>
</div><!-- /#page-wrapper -->
