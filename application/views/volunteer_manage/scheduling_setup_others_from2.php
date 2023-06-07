<style>
  .default_row{
    margin-bottom: 10px;
    min-height: 40px;
  }
  .default_row .col-md-4:nth-child(2)
  {
    text-align: center;
  }
  .default_row .col-md-4:nth-child(3)
  {
    text-align: right;
  }
  #calendar tr td{
    border: 1px solid black ;
    height: 90px;
    text-align: center;
  }
  #calendar tr.date_title td{
    border: 1px solid black ;
    height: 20px;
    text-align: center;
  }
  #calendar tr th{
    border: 1px solid black ;
    text-align: center;
    background-color: #f7cd99; /*#f96363*/
    color: #000;
    font-size: 18px;
  }
</style>
<hr>
<form action="" method="POST">
  <input type="hidden" name="search[year]" value="<?=$search['year']?>">
  <input type="hidden" name="search[month]" value="<?=$search['month']?>">
  <input type="hidden" name="default_setting[year]" value="<?=$search['year']?>">
  <input type="hidden" name="default_setting[month]" value="<?=$search['month']?>">
  <input type="hidden" name="default_setting[vcID]" value="<?=$default['vcID']?>" id="vcID">
  <div class="row default_row">
    <div class="col-md-4">
      <?php 
      if(isset($default[1]))
      {?>
        <label for="">上午班　起迄時間：</label><br>
        <?php 
          $input = new input_builder('text','default_setting[type][1][start]',$volunteer_data->morning_start);
          $input->set_style('width:120px;display:inline-block')
                ->print_html();

          echo ' ~ ';

          $input = new input_builder('text','default_setting[type][1][end]',$volunteer_data->morning_end);
          $input->set_style('width:120px;display:inline-block')
                ->print_html();
      }
      ?>
    </div>
    <div class="col-md-4">
      <?php 
      if(isset($default[2]))
      {?>
        <label for="">下午班　起迄時間：</label><br>
        <?php 
          $input = new input_builder('text','default_setting[type][2][start]',$volunteer_data->afternoon_start);
          $input->set_style('width:120px;display:inline-block')
                ->print_html();

          echo ' ~ ';
          
          $input = new input_builder('text','default_setting[type][2][end]',$volunteer_data->afternoon_end);
          $input->set_style('width:120px;display:inline-block')
                ->print_html();
      }
      ?>
    </div>
    <div class="col-md-4">
      <?php 
      if(isset($default[3]))
      {?>
        <label for="">夜間班　起迄時間：</label><br>
        <?php 
          $input = new input_builder('text','default_setting[type][3][start]');
          $input->set_style('width:120px;display:inline-block')
                ->print_html();

          echo ' ~ ';
                  
          $input = new input_builder('text','default_setting[type][3][end]');
          $input->set_style('width:120px;display:inline-block')
                ->print_html();
      }
      ?>
    </div>
  </div>
  <div class="row default_row">
    <div class="col-md-4">
      <?php 
      if(isset($default[1]))
      {?>
        <label for="">上午班　是否排班：</label>
        <input type="hidden" name="default_setting[type_status][1]" value="0">
        &emsp;<input type="checkbox" name="default_setting[type_status][1]" class="switch-small switchchk" value="1" data-on-text="排班" data-off-text="不排班" data-table="PT_planning_handler" data-size="mini" <?=($default[1]?'checked="checked"':null)?>>
      <?php
      }
      ?>
    </div>
    <div class="col-md-4">
      <?php 
      if(isset($default[2]))
      {?>
        <label for="">下午班　是否排班：</label>
        <input type="hidden" name="default_setting[type_status][2]" value="0">
        &emsp;<input type="checkbox" name="default_setting[type_status][2]" class="switch-small switchchk" value="1" data-on-text="排班" data-off-text="不排班" data-table="PT_planning_handler" data-size="mini" <?=($default[2]?'checked="checked"':null)?>>
      <?php
      }
      ?>

    </div>
    <div class="col-md-4">
      <?php 
      if(isset($default[3]))
      {?>
        <label for="">夜間班　是否排班：</label>
        <input type="hidden" name="default_setting[type_status][3]" value="0">
        &emsp;<input type="checkbox" name="default_setting[type_status][3]" class="switch-small switchchk" value="1" data-on-text="排班" data-off-text="不排班" data-table="PT_planning_handler" data-size="mini" <?=($default[3]?'checked="checked"':null)?>>
      <?php
      }
      ?>
    </div>
  </div>

  <div class="row default_row">
    <div class="col-md-4">
      <label for="">每周六　是否排班：</label>
      <input type="hidden" name="default_setting[week][Saturday]" value="0">
      &emsp;<input type="checkbox" name="default_setting[week][Saturday]" class="switch-small switchchk" value="1" data-on-text="排班" data-off-text="不排班" data-table="PT_planning_handler" data-size="mini">
    </div>
    <div class="col-md-4">
      <label for="">每周日　是否排班：</label>
      <input type="hidden" name="default_setting[week][Sunday]" value="0">
      &emsp;<input type="checkbox" name="default_setting[week][Sunday]" class="switch-small switchchk" value="1" data-on-text="排班" data-off-text="不排班" data-table="PT_planning_handler" data-size="mini">
    </div>
    <div class="col-md-4">
      <button>
        設　定
      </button>
    </div>
  </div>
</form>

  <?php 
    if($vID == 3)
    {?>
      <div class="row default_row">
        <div class="col-md-8">
          <label for="">圖書志工服務人次備註：</label>
          <?php 
            $input = new input_builder('text','default_setting[special_note]',$volunteer_data->special_note);
            $input->set_style('width:220px;display:inline-block')
                  ->print_html();
          ?>
          <button id="btn_set_volinteer_service_personnel">
            設　定
          </button>      
        </div>
        <div class="col-md-4" style="text-align: right">
        </div>
      </div>
    <?php
    }
  ?>
<div>
  
  <?php 
  if(!empty($list))
  {
    $TYPE_INDEX = array(
      '1'=>'上午',
      '2'=>'下午',
      '3'=>'晚間',
    );

    $week_num = ceil((count($list)+count($empty_date))/7.0);
    echo '<table id="calendar" width="100%">';
    echo '
    <tr>
      <th style="width:150px">星期</th>
      <th>週日</th>
      <th>週一</th>
      <th>週二</th>
      <th>週三</th>
      <th>週四</th>
      <th>週五</th>
      <th>週六</th>
    </tr>
    ';

    $empty_date_title = $empty_date;

    $list_title = $list;

    // 有幾周
    for ($i=1; $i <= $week_num; $i++)
    { 
      echo '<tr class="date_title">';
      echo '<th>日期</th>';
      for ($j=1; $j <= 7; $j++)
      { 
        if(!empty($empty_date_title))
        {
          $date = key($empty_date_title);
          $date_data = array_pop($empty_date_title);
          echo '<th><label for="">'.ROCdate('Y-m-d',strtotime($date_data)).'</label></th>';
        }
        elseif(!empty($list_title))
        {
          $date = key($list_title);
          array_shift($list_title);
          echo '<th><label for="">'.ROCdate('Y-m-d',strtotime($date)).'</label></th>';
        }
      }
      echo '</tr>';

      echo '<tr>';
      echo '<th style="font-size:12px;background-color:#c0f0f5">'; //#a23737
      if(isset($default[1]))
      {
        echo '<div style="margin-bottom:15px">';
        echo '上午：';
        if((!empty($volunteer_data->morning_start) || !empty($volunteer_data->morning_end)))
          echo ($volunteer_data->morning_start?$volunteer_data->morning_start:'(未設定)').' ~ '.($volunteer_data->morning_start?$volunteer_data->morning_end:'(未設定)');
        else
          echo '(未設定)';
        echo '</div>';
      }
      if(isset($default[2]))
      {
        echo '<div style="margin-bottom:15px">';
        echo '下午：';
        if((!empty($volunteer_data->afternoon_start) || !empty($volunteer_data->afternoon_end)))
          echo ($volunteer_data->afternoon_start?$volunteer_data->afternoon_start:'(未設定)').' ~ '.($volunteer_data->afternoon_start?$volunteer_data->afternoon_end:'(未設定)');
        else
          echo '(未設定)';
        echo '</div>';
      }
      if(isset($default[3]))
      {
        echo '<div style="margin-bottom:15px">';
        echo '晚間：';
        if((!empty($volunteer_data->night_start) || !empty($volunteer_data->night_end)))
          echo ($volunteer_data->night_start?$volunteer_data->night_start:'(未設定)').' ~ '.($volunteer_data->night_start?$volunteer_data->night_end:'(未設定)');
        else
          echo '(未設定)';
        echo '</div>';
      }

      echo '</th style="font-size:12px;background-color:#a23737">';
      for ($d=1; $d <= 7; $d++)
      { 
        if(!empty($empty_date))
        {
          $date = key($empty_date);
          $date_data = array_pop($empty_date);
          echo '<td style="background-color:gray"></td>';
        }
        elseif(!empty($list))
        {
          $date = key($list);
          $date_data = array_shift($list);
          echo '<td>';
          // echo '<label for="">'.ROCdate('Y-m-d',strtotime($date)).'</label><br>';
          foreach ($date_data as $type => $each)
          {
            echo '<div style="margin-bottom:15px">';
            echo '
              <div>
                
                <div style="display:inline-block;width:100%">
                  <input style="width:100%" type="checkbox" name="single_setting['.$each->id.']" data-id="'.$each->id.'" class="single_setting switch-small switchchk" value="1" data-on-text="排班" data-off-text="不排班" data-table="PT_planning_handler" data-size="mini" '.($each->status?'checked="checked"':null).'>
                </div>
              </div>
            ';
            if(!in_array($vID,array(1,4,2,5)))
            {
              echo '
                <div style="margin-top:2px">
                  <div style="width:85px;display:inline-block;">服務人次：</div>
                  <div style="width:calc(100% - 90px);display:inline-block">
                    <input style="width: calc(100% - 7px);height: 20px;" type="text" class="person" data-id="'.$each->id.'" value="'.$each->person.'">
                  </div>
                </div>
              ';
            }
            echo'</div>';
          }
          echo '</td>';
        }
        else
        {
          echo '<td style="background-color:gray"></td>';
        }
      }
      echo '</tr>';
    }

    echo '</table>';
  }           
  else
  {
    echo '此時段尚未設定排班時間，請填寫上方欄位後，點選設定。';
  }
  ?>
</div>
<script>
    $(function(){
      $(".switchchk").bootstrapSwitch();
    });
    $('.single_setting').bootstrapSwitch({

        onSwitchChange:function(e, state){
          var status = state?1:0;
          var id = $(this).attr('data-id');
          var post_data = {'id':id,'status':status,};

          $.post(
             "<?php echo base_url('volunteer_manage/single_setting');?>",
             post_data,
             function(data){
              data = $.parseJSON(data);
              setTimeout(function() {
                alert(data.msg);
              }, 1300);
              
             }
          );
        }
    });
    $('.person').on('change',function(){
          var person = $(this).val();
          var id = $(this).attr('data-id');
          var post_data = {'id':id,'person':person};

          $.post(
             "<?php echo base_url('volunteer_manage/single_setting');?>",
             post_data,
             function(data){
              data = $.parseJSON(data);
              setTimeout(function() {
                alert(data.msg);
              }, 1300);
              
             }
          );
    })

    // -------- 0313 鵬 ---------------------------------------
     $('#btn_set_volinteer_service_personnel').on('click',function(){
        var comment_input = $('.form-control')[6].value;
        var post_data = {'vcID':'' + $('#vcID').val() , 'special_note':comment_input};
    
        $.post(
            "<?php echo base_url('volunteer_manage/setVolinteer_service_personnel');?>",
            post_data,
            function(){
              alert('圖書志工服務人次備註設定成功');
            }
        );
        
      });
    //--------------------------------------------------------

</script>
