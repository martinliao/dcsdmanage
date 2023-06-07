<?php
$id = isset($course->id)?$course->id:null;
$name = isset($course->name)?$course->name:null;
$need = isset($course->need)?$course->need:1;
$list = isset($list)?$list:array();
?>

<div class="row">
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h1 class="box-title">
                <?php echo $name ?>                
            </h1>
        </div>
        <div class="box-body">
            <div>
                <div id="main_div" class="special_scrollbar" style="overflow-x: auto;">
                <form action="<?php echo base_url('/volunteer_manage/save') ?>" method="POST">
                    <input type="hidden" name="id" value="<?=$id?>">
                    <table id="main_table" class="table table-bordered table-hover" width="100%">
                        <thead>
                            <tr>
                                <td style="text-align: center;">
                                    <label>是否需要志工</label>
                                </td>
                                <td style="text-align: center;">

                                    <?php 
                                        $input = new input_builder('radio','need',$need);
                                        $input->set_option(array(1=>'是',0=>'否'))
                                              ->print_html();
                                    ?>
                                </td>
                                <td colspan="3"></td>
                            </tr>
                          <tr>
                            <th style="text-align:center;">上課日期</th>
                            <th style="text-align:center;">起</th>
                            <th style="text-align:center;">迄</th>
                            <th style="text-align:center;">志工時數</th>
                            <th style="text-align:center;">啟用</th>
                          </tr> 
                        </thead>
                        <?php 
                        foreach ($list as $date => $each_calendar)
                        {?>
                            <tr>
                                <td style="text-align: center;vertical-align: middle;">
                                    <?php echo $date ?>
                                </td>
                                <td>
                                <?php 
                                    if(isset($each_calendar[1]))
                                    {
                                        echo '<div style="text-align:center">早上　';
                                        $input = new input_builder('text','calendar['.$each_calendar[1]->id.'][start_time]',$each_calendar[1]->start_time);
                                        $input->set_id('calendar_'.$each_calendar[1]->id.'_start_time')
                                              ->set_style('display: inline-block;width: 120px;')
                                              ->print_html();
                                        echo '</div>';
                                    }

                                    if(isset($each_calendar[2]))
                                    {
                                        echo '<div style="text-align:center">下午　';
                                        $input = new input_builder('text','calendar['.$each_calendar[2]->id.'][start_time]',$each_calendar[2]->start_time);
                                        $input->set_id('calendar_'.$each_calendar[2]->id.'_start_time')
                                              ->set_style('display: inline-block;width: 120px;')
                                              ->print_html();
                                        echo '</div>';
                                    }

                                    if(isset($each_calendar[3]))
                                    {
                                        echo '<div style="text-align:center">晚上　';
                                        $input = new input_builder('text','calendar['.$each_calendar[3]->id.'][start_time]',$each_calendar[3]->start_time);
                                        $input->set_id('calendar_'.$each_calendar[3]->id.'_start_time')
                                              ->set_style('display: inline-block;width: 120px;')
                                              ->print_html();
                                        echo '</div>';
                                    }
                                ?>
                                </td>
                                <td>
                                <?php 
                                    if(isset($each_calendar[1]))
                                    {
                                        echo '<div style="text-align:center">早上　';
                                        $input = new input_builder('text','calendar['.$each_calendar[1]->id.'][end_time]',$each_calendar[1]->end_time);
                                        $input->set_id('calendar_'.$each_calendar[1]->id.'_end_time')
                                              ->set_style('display: inline-block;width: 120px;')
                                              ->print_html();
                                        echo "</div>";
                                    }
                                    if(isset($each_calendar[2]))
                                    {
                                        echo '<div style="text-align:center">下午　';
                                        $input = new input_builder('text','calendar['.$each_calendar[2]->id.'][end_time]',$each_calendar[2]->end_time);
                                        $input->set_id('calendar_'.$each_calendar[2]->id.'_end_time')
                                              ->set_style('display: inline-block;width: 120px;')
                                              ->print_html();
                                        echo '</div>';
                                    }
                                    if(isset($each_calendar[3]))
                                    {
                                        echo '<div style="text-align:center">晚上　';
                                        $input = new input_builder('text','calendar['.$each_calendar[3]->id.'][end_time]',$each_calendar[3]->end_time);
                                        $input->set_id('calendar_'.$each_calendar[3]->id.'_end_time')
                                              ->set_style('display: inline-block;width: 120px;')
                                              ->print_html();
                                        echo '</div>';
                                    }
                                ?>
                                </td>
                                <td>
                                <?php 
                                    if(isset($each_calendar[1]))
                                    {
                                        echo '<div style="text-align:center">';
                                        $input = new input_builder('text','calendar['.$each_calendar[1]->id.'][hours]',$each_calendar[1]->hours);
                                        $input->set_id('calendar_'.$each_calendar[1]->id.'_hours')
                                              ->set_style('display: inline-block;width: 120px;')
                                              ->print_html();
                                        echo '　(時)</div>';
                                    }
                                    if(isset($each_calendar[2]))
                                    {
                                        echo '<div style="text-align:center">';
                                        $input = new input_builder('text','calendar['.$each_calendar[2]->id.'][hours]',$each_calendar[2]->hours);
                                        $input->set_id('calendar_'.$each_calendar[2]->id.'_hours')
                                              ->set_style('display: inline-block;width: 120px;')
                                              ->print_html();
                                        echo '　(時)</div>';
                                    }
                                    if(isset($each_calendar[3]))
                                    {
                                        echo '<div style="text-align:center">';
                                        $input = new input_builder('text','calendar['.$each_calendar[3]->id.'][hours]',$each_calendar[3]->hours);
                                        $input->set_id('calendar_'.$each_calendar[3]->id.'_hours')
                                              ->set_style('display: inline-block;width: 120px;')
                                              ->print_html();
                                        echo '　(時)</div>';
                                    }
                                ?>
                                </td>
                                <td>
                                <?php 
                                    if(isset($each_calendar[1]))
                                    {
                                        echo '<div style="text-align:center">';
                                        $input = new input_builder('checkbox','calendar['.$each_calendar[1]->id.'][status]',$each_calendar[1]->status);
                                        $input->set_id('calendar_'.$each_calendar[1]->id.'_status')
                                              ->set_option(array(1=>''))
                                              ->print_html();
                                        echo '</div>';
                                    }
                                    if(isset($each_calendar[2]))
                                    {
                                        echo '<div style="text-align:center">';
                                        $input = new input_builder('checkbox','calendar['.$each_calendar[2]->id.'][status]',$each_calendar[2]->status);
                                        $input->set_id('calendar_'.$each_calendar[2]->id.'_status')
                                              ->set_option(array(1=>''))
                                              ->print_html();
                                        echo "</div>";
                                    }
                                    if(isset($each_calendar[3]))
                                    {
                                        echo '<div style="text-align:center">';
                                        $input = new input_builder('checkbox','calendar['.$each_calendar[3]->id.'][status]',$each_calendar[3]->status);
                                        $input->set_id('calendar_'.$each_calendar[3]->id.'_status')
                                              ->set_option(array(1=>''))
                                              ->print_html();
                                        echo "</div>";                                              
                                    }                         
                                ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                    <div style="width: 100%;text-align: right;padding-right: 20px">
                        <button>儲存</button>                        
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
