<?php
$year = isset($search['year'])?$search['year']:date('Y');
$month = isset($search['month'])?$search['month']:date('m');
$id = isset($setting)?$setting->id:null;
$volunteerID = isset($setting)?$setting->volunteerID:null;
$apply_start = isset($setting)?$setting->apply_start:null;
$apply_end = isset($setting)?$setting->apply_end:null;
$note = isset($note)?$note:'';
?>

<div class="row">
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h1 class="box-title">
                B.報名時間設定：<?php echo $volunteer_data->name ?>
            </h1>
        </div>
        <div class="box-body">
            <div>
                <div id="main_div" class="special_scrollbar" style="overflow-x: auto;">
                    <form action="" method="POST">
                        <div>
                        <select class='form-control input-sm' name='year' style='width:80px;display:inline-block'>
                        <?php
                            $y = date('Y')-1911;

                            for($i=0;$i<5;$i++){
                                if(($y+$i) == $year){
                                    echo '<option values="'.($y+$i).'" selected>'.($y+$i).'</option>';
                                } else {
                                    echo '<option values="'.($y+$i).'">'.($y+$i).'</option>';
                                }
                                
                            }
                            echo '</select>';
                            echo ' 年 ';

                            $input = new input_builder('select','month',$month);
                            $input->set_option(array(1 =>1,2 =>2,3 =>3,4 =>4,5 =>5,6 =>6,7 =>7,8 =>8,9 =>9,10 =>10,11 =>11,12 =>12,))
                                  ->set_style('width:80px;display:inline-block')
                                  ->print_html();
                            echo ' 月 ';
                        ?>
                            <button type="submit" class="btn btn-success btn-flat">確定</button>                            
                        </div>
                    </form>
                    <?php if(isset($setting)){?>
                        <form action="<?php echo base_url('/volunteer_manage/apply_time_setting_others_save') ?>" method="POST">
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input type="hidden" name="vID" value="<?php echo $volunteerID ?>">
                            <table id="main_table" class="table table-bordered table-hover" width="100%">
                                <tr>
                                    <td>
                                        設定報名日期限制：起
                                        <?php
                                            $input = new input_builder('date','apply_start',$apply_start);
                                            $input->set_style('display:inline-block;width:180px')
                                                  ->print_html();
                                        ?>
                                        迄
                                        <?php
                                            $input = new input_builder('date','apply_end',$apply_end);
                                            $input->set_style('display:inline-block;width:180px')
                                                  ->print_html();
                                        ?><br>
                                        注意事項<br>
                                        <?php
                                            $input = new input_builder('textarea','note',$note);
                                            $input->print_html();
                                        ?><br>
                                    </td>
                                </tr>
                            </table>
                            <div style="width: 100%;text-align: right;padding-right: 20px">
                                <button>儲存</button>                        
                            </div>
                        </form>
                    <?php
                    }?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
