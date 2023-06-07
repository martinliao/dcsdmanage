<style>
    #main_table{
        font-family: '微軟正黑體';
    }
    #main_table th,#main_table td{
        padding: 5px;
        text-align: center;
    }
    #main_table td.apply_data_list {
        padding: 0px;
        height: 460px;
        min-height: 460px;
    }
    div.apply_info{
        padding: 5px
    }

    #main_table th{
        background-color: #0e324d;
        color: white;
        text-align: center;
        font-size: 16px;
        font-weight: 600;
    }
    #main_table th.week_title{
        background-color: #4e95cc;
    }
    #main_table th.date_disabled{
        background-color: #FFF;
        color: #000;
    }
    #main_table td.date_disabled{
        background-color: #a7a7a7;
    }
    .can_apply {
        background-color: #10da3747 !important; 
    }
    .already_registered {
        background-color: #d8665861 !important; 
    }
    .applied {
        background-color: #d8665861 !important; 
    }
    .can_apply label {
        padding: 5px !important; 
        color: #000 !important; 
        font-weight: bold !important;
        display: block;
        height: 130px;
        overflow: hidden;
    }
    .can_apply .applied_person {
        padding: 0px 10px;
        border-color: #f1b44c;
        color: #000;
        font-weight: 500;
        margin: 0px 0px; ;
    }

    #up_week {
        background: #2a3042; padding: 5px 20px; color: #FFF; letter-spacing: 2px;
    }
    #next_week {
        background: #2a3042; padding: 5px 20px; color: #FFF; letter-spacing: 2px;
    }

    #main_table tr th,#main_table tr td{
        /*border: 1px solid #00000091;*/
        border-width: 1px;
        border-style: solid;
        border-color: #00000091;

    }
    tr.data_row>td>div{
        min-height: 60px;
    }
    .px60{
        min-width: 60px;
        width: 60px;
    }
    .px120{
        min-width: 120px;
        width: 120px;
    }
    .px135{
        min-width: 135px;
        width: 135px;
    }
    .px180{
        min-width: 180px;
        width: 180px;
    }
    hr.break_line{
        border-style: dashed;
        border-color: #636363;
        border-width: 1px;
        margin-top: -2px;
        margin-bottom: 0px;
        margin-right: 5px;
        margin-left: 5px;
    }
    div.can_apply{
        background-color: #51cf56cc;
    }
    div.applied{
        background-color: #ffd8a2;
    }
    div.long_range{
        background-color: #8ea0ff;
    }
    button.applied{
        background-color: #bdbdff;
        color: black;
        border-color: blanchedalmond;
        font-weight: 600;
    }

     /* 2019 05 06 鵬加上  解決 td 跑掉的問題*/
    table {
        /* table-layout: fixed;
        word-wrap:break-word; */
        word-break: break-all;
    }
    .fix_height {
      height: 1px;
    }

    @-moz-document url-prefix() {
       .fix_height {
            height: 100%;
        }
    }
</style>

<style>    
    #main_div{
        overflow: hidden;
    }
    .fixed_header tbody{
        display:block;
        overflow:auto;
        overflow:overlay;
        width:100%;
    }
    .fixed_header thead tr{
      display:block;
    }

    .got_it{
        color: #e60000;
    }

    .special_scrollbar::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius: 10px;
        background-color: #F5F5F5;
    }

    .special_scrollbar::-webkit-scrollbar
    {
        width: 8px;
        height: 8px;
        background-color: #F5F5F5;
    }

    .special_scrollbar::-webkit-scrollbar-thumb
    {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #555;
    }
</style>

<script>
    $(function(){
        var total_height = $('.content-wrapper').css('min-height');
        total_height = total_height.replace(/[a-z ]/gi,"");
        $('#main_table.fixed_header tbody').css('height',(total_height - 260)+'px');
        $('#main_div').css('height',(total_height - 200)+'px');
    });
</script>

<?php 
$NOW_MONTH = date('m');
$SHOW_MONTH = ($NOW_MONTH+1)%12;
$WEEK_INDEX = array(
    0 => '日',
    1 => '一',
    2 => '二',
    3 => '三',
    4 => '四',
    5 => '五',
    6 => '六',
);
// $WEEK_INDEX = array(
//     0 => '一',
//     1 => '二',
//     2 => '三',
//     3 => '四',
//     4 => '五'
// );
$TIME_TYPE_INDEX = array(
    1 => '上午',
    2 => '下午',
    3 => '晚上',
);


// seeData(date('Y-m-d',strtotime(($week_list[3]).'-4 day')));
?>

<div class="row">
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">D.公告檢視</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div>
                <form id="post_form" method="POST" action="<?php echo base_url('/volunteer_manage/publish_detail/') ?>">
                    <select name="year">
                    <?php 
                        $y = date('Y')-1911-2;
                            
                        for($i=0;$i<5;$i++){
                            $selected = (($y+$i) == (date('Y') -1911)) ? 'selected' : '';
                            echo '<option values="'.($y+$i).'" '.$selected.'>'.($y+$i).'</option>';
                        }
                    ?>
                    </select>
                    年
                    <select name="month_start">
                    <?php 
                        for ($m=1; $m <= 12; $m++)
                        { 
                            if(isset($default_month)){
                                echo '<option value="'.str_pad($m,2,'0',STR_PAD_LEFT).'" '.((intval($default_month))==$m?'selected':null).'>'.str_pad($m,2,'0',STR_PAD_LEFT).'</option>';
                            } else {
                                echo '<option value="'.str_pad($m,2,'0',STR_PAD_LEFT).'" '.((date('m'))==$m?'selected':null).'>'.str_pad($m,2,'0',STR_PAD_LEFT).'</option>';
                            }
                        }
                    ?>
                    </select>
                    月
                    <button type="submit">確認</button>
                    <a href="<?php echo base_url('/volunteer_manage/publish_detail/'.$export_date.'?export=1&default='.$default.'&'.$vID_str) ?>"><button type="button">匯出</button></a>
                    <div>
                        <label><input type="checkbox" name="vID[all]" value="1" class="all vID" <?php echo $all_checked?'checked="checked"':null ?>>全部</label>&emsp;
                        <?php 
                        foreach ($v_list as $vID => $each)
                        {
                            echo '<label><input type="checkbox" name="vID['.$vID.']" value="1" class="vID" '.($each['checked']?'checked="checked"':null).'>'.$each['name'].'</label>&emsp;';
                        }
                        ?>
                    </div>
                    <div>
                        <label><input type="checkbox" name="not_show" value="1" <?=($not_show=='1'?'checked="checked"':null)?>>不顯示處外教室</label>
                    </div>
                </form>
                
                <style type="text/css">
                #accordion {
                    margin: 20px 0px;
                }
                #accordion-open {
                    float: right;
                    padding: 5px 10px;
                    background: #f2a2a2;
                    font-weight: 600;
                    position: absolute;
                    right: 0px;
                    top: -5px;
                }
                </style>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title" style="position: relative;">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    公告資訊
                                </a>
                                <a id="accordion-open" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    開啟
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                注意事項：<?php echo nl2br($note); ?>
                                <br>
                                公告更新時間：<?php echo date('Y/m/d H:i:s');?>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <hr>
            <div style="padding-left: calc((100% - 797px) / 2);padding-right: calc((100% - 797px) / 2);">
            <?php if($default){ ?>
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-md-4" style="text-align: left">
                        <a href="<?php echo base_url('/volunteer_manage/publish_detail/'.strtotime(($week_list[3]).'-4 day').'?default=1&'.$vID_str) ?>"><button id="up_week">《上一週</button></a>
                    </div>                
                    <div class="col-md-4">
                        
                    </div>                
                    <div class="col-md-4" style="text-align: right">
                        <a href="<?php echo base_url('/volunteer_manage/publish_detail/'.strtotime(($week_list[3]).'+4 day')).'?default=1&'.$vID_str ?>"><button id="next_week">下一週》</button></a>
                    </div>                
                </div>
            <?php } ?>
                <div id="main_div" class="special_scrollbar" style="overflow-x: auto;">
                    <table id="main_table" class="fixed_header" width="100%">
                        <thead>
                            <tr>
                                <th class="px120">
                                    志工<br>類別
                                </th>
                                <!-- <th class="px120">
                                    場地
                                </th> -->
                                <?php 
                                foreach ($week_list as $key => $date)
                                {
                                   
                                    $week_day = $WEEK_INDEX[date('w',strtotime($date))];
                                    $roc_date = (date('Y',strtotime($date))-1911).'-'.date('m-d',strtotime($date));
                                    // echo '
                                    // <th class="px135 week_title '.(date('m',strtotime($date))!=$SHOW_MONTH?'date_disabled':null).'" date_no_in_pre_week="'.$key.'">
                                    //     <span class="date">'.$roc_date.'</span><br>
                                    //     ('.$week_day.')
                                    // </th>
                                    // ';
                                    echo '
                                    <th class="px135 week_title date_disabled" date_no_in_pre_week="'.$key.'">
                                        <span class="date">'.$roc_date.'</span><br>
                                        ('.$week_day.')
                                    </th>
                                    ';
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody class="special_scrollbar" style="height:500px;">
                        <?php 
                            foreach ($vc_list as $vID => $pre_classroom_for_each_volunteer)
                            {
                                if(!isset($vID_arr[$vID]))
                                    continue;

                                $rowspan = count($pre_classroom_for_each_volunteer);
                                $rowspan_done = false;
                                foreach ($pre_classroom_for_each_volunteer as $cID => $vc_data)
                                {
                                    echo '<tr class="data_row">';
                                    if($vc_data->others)
                                    {
                                        echo '<td class="px120" rowspan="'.$rowspan.'"  style="font-size: 20px;word-break: break-all;"><b>'.$vc_data->volunteerName.'</b></td>';
                                    }
                                    else
                                    {
                                        if(!$rowspan_done){
                                            if(count($vID_arr) == 1){
                                                echo '<td class="px120" rowspan="'.$rowspan.'"  style="font-size: 20px;"><b>'.$vc_data->volunteerName.'</b></td>';
                                            } else {
                                                echo '<td class="px60" rowspan="'.$rowspan.'"  style="font-size: 20px;"><b>'.$vc_data->volunteerName.'</b></td>';
                                            }
                                           
                                        }

                                        // echo '<td class="px120" style="font-size: 18px;"><b>'.$vc_data->classroomName.'</b></td>';
                                    }
                                    $rowspan_done = true;                            


                                    foreach ($week_list as $key => $date)
                                    {
                                        $there_is_data = false;
                                        $data_str = '<div style="height:50%;text-align:left" class="apply_info">
                                                            
                                                            <div style="text-align:center;margin-top:50%" class="applied_person">
                                                                <span>(未開放)</span>
                                                                <br>
                                                                <span></span>
                                                                <br>
                                                                <span></span>
                                                                <br>
                                                            </div>
                                                            
                                                        </div><hr class="break_line"><div style="height:50%;text-align:left" class="apply_info">
                                                            
                                                            <div style="text-align:center;margin-top:50%" class="applied_person">
                                                                <span>(未開放)</span>
                                                                <br>
                                                                <span></span>
                                                                <br>
                                                                <span></span>
                                                                <br>
                                                            </div>
                                                            
                                                        </div>';

                                        // 如果是可以顯示的月份
                                        // if(date('m',strtotime($date))==$SHOW_MONTH)
                                        // {
                                            // 如果這天有資料
                                            if(!empty($calendar_list[$vc_data->vcID][$date]))
                                            {
                                                $list_str = array();
                                                
                                                foreach ($calendar_list[$vc_data->vcID][$date] as $type => $calendar_data)
                                                {
                                                    // 如果不開放就PASS
                                                    if(!$calendar_data->status)
                                                        continue;

                                                    // 如果不在報名時間內也PASS
                                                    if(isset($calendar_data->apply_start) && $calendar_data->apply_end && (date('Y-m-d')< $calendar_data->apply_start || date('Y-m-d')> $calendar_data->apply_end ))
                                                        continue;


                                                    if($ONLY_ME && empty($apply_data[$calendar_data->id][$userID]))
                                                        continue;

                                                    $there_is_data = true;                                                    

                                                    // 時段的標題文字，僅班務志工要顯示課程名稱
                                                    $time_str = date('Hi',strtotime($calendar_data->start_time)).'~'.date('Hi',strtotime($calendar_data->end_time)).'('.$vc_list[$calendar_data->volunteerID][$calendar_data->vcID]->volunteerName.')';
                                                    if($calendar_data->belongto == '68001'){
                                                        $calendar_data->sname .= '<font style="color:red;font-size:20px">★</font>';
                                                    } else {
                                                        $outside_key = $calendar_data->date.'-'.$calendar_data->courseID;
                                                        if(in_array($outside_key, $outside)){
                                                            $calendar_data->sname .= '<font style="color:red;font-size:20px">★</font>';
                                                        }
                                                    }
                                                    $title_str = $time_str.(!empty($calendar_data->courseName)?'&nbsp;'.$calendar_data->courseName.'('.$calendar_data->term.')'.$calendar_data->worker.'('.$calendar_data->hours.')<br>'.$calendar_data->sname:null);

                                                    // 報名按鈕
                                                    $action = 'apply(\''.$calendar_data->id.'\')';
                                                    $action_str = '報名';
                                                    $applied_class = null;
                                                    $can_apply_class = 'can_apply';
                                                    $applied_count = isset($apply_data[$calendar_data->id])?count($apply_data[$calendar_data->id]):0;

                                                    // 如果已經報名過了
                                                    if(!empty($apply_data[$calendar_data->id][$userID]))
                                                    {
                                                        $action = 'cancel(\''.$apply_data[$calendar_data->id][$userID]->id.'\')';
                                                        $action_str = '取消';
                                                        $applied_class = 'applied';
                                                        $button_str = '<div style="width:100%; text-align:right"><button class="'.$applied_class.'" onclick="'.$action.'">'.$action_str.'</button></div>';                                                        
                                                    }
                                                    else
                                                    {
                                                        // 報名按鈕(如果額滿則不顯示)
                                                        $button_str = '<div style="width:100%; text-align:right"><button class="'.$applied_class.'" onclick="'.$action.'">'.$action_str.'</button></div>';
                                                        if($calendar_data->num_got_it+$calendar_data->num_waiting <= $applied_count && empty($applied_class))
                                                        {
                                                            $can_apply_class = null;
                                                            $button_str = null;
                                                        }
                                                        // 如果不在報名期間內也不顯示
                                                        if(isset($calendar_data->apply_start) && $calendar_data->courseID && (date('Y-m-d')< $calendar_data->apply_start || date('Y-m-d')> $calendar_data->apply_end ))
                                                        {
                                                            $can_apply_class = null;
                                                            $action = 'alert(\'現在不是報名期間!\\n('.$calendar_data->apply_start.'~'.$calendar_data->apply_end.')\')';
                                                            $button_str = '<div style="width:100%; text-align:right"><button class="'.$applied_class.'" onclick="'.$action.'">'.$action_str.'</button></div>';
                                                        }                                                        
                                                    }

                                                    // 報名按鈕一律不顯示
                                                    $button_str = null;

                                                    $long_range_class = $calendar_data->long_range?'long_range':null;


                                                    if(!empty($apply_data[$calendar_data->id]))
                                                    {
                                                        $already_registered = "already_registered" ;
                                                    } else {
                                                        $already_registered = "" ;
                                                    }

                                                    $tmp_str = '
                                                        <div style="height:50%;text-align:left" class="apply_info '.$can_apply_class.' '.$applied_class.' '.$already_registered.' '.$long_range_class.'">
                                                            <label>'.$title_str.'</label>
                                                            <div style="text-align:center" class="applied_person">';
                                                    if(!empty($apply_data[$calendar_data->id]))
                                                    {
                                                        $users = array();
                                                        foreach ($apply_data[$calendar_data->id] as $key_userID => $each_applied_user)
                                                        {
                                                            $userName_str = $each_applied_user->userName_enc;
                                                            if($each_applied_user->got_it)
                                                                $userName_str = '<span class="got_it">'.$userName_str.'</span>';
                                                            $users[] = $userName_str;
                                                        }

                                                        if(count($users) < 3){
                                                            $tmp_test = 3 - count($users);
                                                            for($kk=0;$kk<$tmp_test;$kk++){
                                                                // $users[] = '<span class="got_it">&nbsp;</spna>';
                                                            }
                                                        }


                                                        $tmp_str.= implode('<br>',$users);
                                                    }
                                                    else                                                        
                                                    {
                                                        $tmp_str.= '<span style="color:#000">未報名</span>';

                                                    }
                                                    $tmp_str .='
                                                            </div>
                                                            '.$button_str.'
                                                    ';

                                                    if ( $vc_data->volunteerName=="班務")
                                                    {
                                                        // 增加跳窗按鈕
                                                        $tmp_str .= '<div style="text-align:center;padding-top: 10px;">
                                                                        <a class="open-course" cid="'.$calendar_data->id.'" date="'.$calendar_data->date.'" vcID="'.$calendar_data->vcID.'" start_time="'.$calendar_data->start_time.'" end_time="'.$calendar_data->end_time.'" courseName="'.$calendar_data->courseName.'" classroomID="'.$calendar_data->classroomID.'" style="background: #0043ff;padding: 3px 10px;color: #FFF;margin-bottom:5px;cursor: pointer;">
                                                                            編輯
                                                                        </a>
                                                                    </div>' ;
                                                    }
                                                    $tmp_str .= '</div>' ;

                                                    $list_str[] = $tmp_str;
                                                    $tmp_type = $calendar_data->type;

                                                }

                                                if(count($list_str) == 1){
                                                    
                                                    // echo '<pre>';
                                                    // print_r($list_str);
                                                    // die();
                                                    if($tmp_type == 1){
                                                        $list_str[] = '<div style="height:50%;text-align:left;" class="apply_info">
                                                            
                                                            <div style="text-align:center;margin-top:50%" class="applied_person">
                                                                <span>(未開放)</span>
                                                            </div>
                                                            
                                                        </div>';
                                                        $gray = 1;
                                                    } else if($tmp_type == 2){
                                                        array_unshift($list_str,'<div style="height:50%;text-align:left" class="apply_info">
                                                            
                                                            <div style="text-align:center;margin-top:50%" class="applied_person">
                                                                <span>(未開放)</span>
                                                            </div>
                                                            
                                                        </div>');
                                                        $gray = 1;
                                                    }
                                                    
                                                }     

                                                if($there_is_data)
                                                {
                                                    // $data_str = '<div style="text-align:left;height:100%;width:100%;">';
                                                    $data_str = '';
                                                    $data_str .= implode('<hr class="break_line">',$list_str);
                                                    // $data_str .= '</div>';                                                    
                                                }
                                            // }
                                        }

                                        echo '<td class="apply_data_list px135 fix_height '.(date('m',strtotime($date))!=$SHOW_MONTH || !$there_is_data || (isset($gray) && $gray=='1')?'date_disabled':null).'">';
                                        echo $data_str;
                                        echo'
                                        </td>
                                        ';
                                    }
                                    echo'</tr>';
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<style type="text/css">
#modal-course-no-user {
    display: none;
}
</style>
<div id="modal-course" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">班務資訊</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <td>課程名稱</td>
                        <td>
                            <input type="text" id="modal-course-courseName" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>教室</td>
                        <td>
                            <select id="modal-course-classroomID" class="form-control">
                                <?php foreach( $classRoomList as $room ) : ?>
                                    <option value="<?php echo $room->id ?>" volunteerID="<?php echo $room->volunteerID ?>">
                                        <?php echo $room->name ?>
                                    </option>
                                <?php endforeach ; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>開始時間</td>
                        <td>
                            <input type="datetime-local" id="modal-course-start" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>結束時間</td>
                        <td>
                            <input type="datetime-local" id="modal-course-end" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>人員</td>
                        <td>
                            <input type="hidden" id="cid">
                            <select id="modal-course-user" class="form-control"></select>
                            <h5 id="modal-course-no-user">
                                沒有報名人員
                            </h5>
                        </td>
                    </tr>
                </table>
                <br>
                <input type="checkbox" id="send-user-msg" value="1">
                通知志工？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger cancel-course">刪除課程</button>
                <button type="button" class="btn btn-primary" id="edit-course" >修改資訊</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
    $('.vID:not(.all)').on('change',function(){
        var all = true;
        $('.vID:not(.all)').each(function(){
            all = all && ($(this).prop('checked'));
            console.log($(this));
            console.log($(this).prop('checked'));
        });
        if(all)
            $('.vID.all').prop('checked',true);
        else
            $('.vID.all').prop('checked',false);            
    });
    $('.vID.all').on('click',function(){
        $('.vID:not(.all)').prop('checked',$(this).prop('checked'));
    });
    function apply(calendarID){
        var post_data = {'calendarID':calendarID};
        $.post('<?php echo base_url('volunteer_apply/apply') ?>', post_data).done(function(response){
            var json = $.parseJSON(response);

            alert(json.msg);

            if(json.success)
            {
                location.reload();
            }
        });
    }
    function cancel(applyID){
        if(confirm('是否確定取消報名?'))
        {
            var post_data = {'applyID':applyID};
            $.post('<?php echo base_url('volunteer_apply/cancel') ?>', post_data).done(function(response){
                var json = $.parseJSON(response);

                alert(json.msg);

                if(json.success)
                {
                    location.reload();
                }
            });
        }
    }


    $(document).on('click', '.open-course', function(event) {
        event.preventDefault();
        /* Act on the event */
        var cid = $(this).attr('cid') ;
        var date = $(this).attr('date') ;
        var start_time = $(this).attr('start_time') ;
        var end_time = $(this).attr('end_time') ;
        var classroomID = $(this).attr('classroomID') ;
        var courseName = $(this).attr('courseName') ;
        // 資訊
        $('#modal-course-courseName').val( courseName ) ;
        $('#modal-course-classroomID').val( classroomID ) ;
        $('#modal-course-start').val( date + 'T' + start_time ) ;
        $('#modal-course-end').val( date + 'T' + end_time ) ;
        // cid
        $('#cid').val( cid ) ;

        $.ajax({
            url: '<?php echo base_url();?>volunteer_manage/get_apply_user',
            type: 'POST',
            dataType: 'json',
            data: {cid: cid},
        })
        .done(function(msg) {
            var str = "" ;
            if ( msg.code=='100' ) {
                $.each(msg.apply_data, function(index, val) {
                    if ( val.got_it=='1' ) {
                        str = str + '<option value="'+val.userId+'">'+val.userName+' (正取)</option>' ;
                    } else {
                        str = str + '<option value="'+val.userId+'">'+val.userName+' (備取)</option>' ;
                    }
                });
            } 
            if ( str=="") {
                $('#modal-course-no-user').show() ;
                $('#modal-course-user').hide() ; ;
            } else {
                $('#modal-course-no-user').hide() ;
                $('#modal-course-user').html(str).show() ; ;
            }
            $('#modal-course').modal('show') ;
        })
        .fail(function() {
            console.log("error");
            alert('系統錯誤，請稍後再試！') ;
        })
        .always(function() {
            console.log("complete");
        });
    });


    $(document).on('click', '#edit-course', function(event) {
        event.preventDefault();
        /* Act on the event */
        var cid = $('#cid').val() ;
        // 資訊
        var courseName  = $('#modal-course-courseName').val() ;
        var classroomID = $('#modal-course-classroomID').val() ;
        var start_time  = $('#modal-course-start').val() ;
        var end_time    = $('#modal-course-end').val() ;

        var send        = '0' ;
        if ( $('#send-user-msg').prop('checked') ) {
            send = '1' ;
        }
        // 防呆
        if ( (Date.parse(start_time)).valueOf() > (Date.parse(end_time)).valueOf()) {
            alert("結束時間小於開始時間!");
            return false ;
        }

        // 確認修改
        if ( confirm('確認修改？') ) {
            // sendData
            var sendData = {
                cid             :   cid             ,
                courseName      :   courseName      ,
                classroomID     :   classroomID     ,
                start_time      :   start_time      ,
                end_time        :   end_time        ,
                send            :   send            ,
            } ;
            $.ajax({
                url: '<?php echo base_url();?>volunteer_manage/edit_course',
                type: 'POST',
                dataType: 'json',
                data: sendData ,
            })
            .done(function(msg) {
                if ( msg.code=='100') {
                    alert('修改完成！') ;
                    location.reload() ;
                } else {
                    alert('系統錯誤，請稍後再試！') ;
                }
                console.log("success");
            })
            .fail(function() {
                console.log("error");
                alert('系統錯誤，請稍後再試！') ;
            })
            .always(function() {
                console.log("complete");
            });
        }
    });


    $(document).on('click', '.cancel-course', function(event) {
        event.preventDefault();
        /* Act on the event */
        var cid = $('#cid').val() ;
        // 資訊
        var courseName  = $('#modal-course-courseName').val() ;
        var end_time    = $('#modal-course-end').val() ;
        var send        = '0' ;
        if ( $('#send-user-msg').prop('checked') ) {
            send = '1' ;
        }
        // 製作
        var sendData = {
            cid             :   cid             ,
            courseName      :   courseName      ,
            end_time        :   end_time        ,
            send            :   send            ,
        } ;
        if ( confirm('確認取消？') ) {
            $.ajax({
                url: '<?php echo base_url();?>volunteer_manage/cancel_course',
                type: 'POST',
                dataType: 'json',
                data: sendData ,
            })
            .done(function(msg) {
                if ( msg.code=='100') {
                    alert('取消完成！') ;
                    location.reload() ;
                } else {
                    alert('系統錯誤，請稍後再試！') ;
                }
                console.log("success");
            })
            .fail(function() {
                console.log("error");
                alert('系統錯誤，請稍後再試！') ;
            })
            .always(function() {
                console.log("complete");
            });
        }
    });


</script>