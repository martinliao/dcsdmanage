<style type="text/css">
    #main_table{
        font-family: '微軟正黑體';
    }
    #main_table th,#main_table td{
        padding: 5px;
        text-align: center;
    }
    #main_table td.apply_data_list{
        padding: 0px
    }
    div.apply_info{
        padding: 5px
    }
    #main_table th{
        background-color: #74d476;
        color: white;
        text-align: center;
        font-size: 16px;
        font-weight: 600;
    }
    #main_table th.week_title{
        background-color: #4e95cc;
    }
    #main_table th.date_disabled{
        background-color: #5e5e5e;
    }
    #main_table td.date_disabled{
        background-color: #8b8b8b;
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
</style>


<div class="row">
<div class="col-xs-12">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">C.志工選員-<?php echo $category->name.'志工';?></h3>
    </div><!-- /.box-header -->
    <div class="box-body">
    <form action="<?php echo base_url();?>Volunteer_select/Volunteer_select_others/<?php echo $vcid;?>" method="POST" id="sentq">
      <select class='form-control input-sm' style='width: auto;float: left;margin-top: 2px' name='year'>
      <?php
        $y = date('Y')-1911;
        for ($i=$y;$i<=($y+5);$i++) { 
          if($year == $i){
            echo '<option values="'.$i.'" selected="selected">'.$i.'</option>';
          } else {
            echo '<option values="'.$i.'">'.$i.'</option>';
          }
        }

      ?>
      </select>
      <p style='float: left;margin-top: 5px'>年</p>
      <select class='form-control input-sm' name='month' style='width: auto;float: left;margin-top: 2px'>
      <?php
        for($i=1;$i<=12;$i++){
          if($month == $i){
            echo '<option values="'.$i.'" selected="selected">'.$i.'</option>';
          } else {
            echo '<option values="'.$i.'">'.$i.'</option>';
          }
        }
      ?>
      </select>
      <p style='float: left;margin-top: 5px'>月</p>
      <button type='button' class='btn btn-success btn-flat' onclick='sentFun()'>搜尋</button>
      <br>
      <br>
      <p style='float: left;margin-right: 5px;margin-top: 3px;font-size: 18px'>正取人數全月設定 星期</p>
      <select class='form-control input-sm' style='width: auto;float: left;margin-top: 2px' name='day[]' multiple="multiple">
        <option value="1">一</option>
        <option value="2">二</option>
        <option value="3">三</option>
        <option value="4">四</option>
        <option value="5">五</option>
        <option value="6">六</option>
        <option value="0">日</option>
      </select>
      <p style='float: left;margin-left: 5px;margin-right: 5px;margin-top: 3px;font-size: 18px'>班次</p>
      <select class='form-control input-sm' style='width: auto;float: left;margin-top: 2px' name='type[]' multiple="multiple">
        <option value="1">上午</option>
        <option value="2">下午</option>
      </select>
      <p style='float: left;margin-left: 5px;margin-right: 5px;margin-top: 3px;font-size: 18px'>正取</p>
      <input type="text" name="num_got_it" value="" style='width: auto;float: left;margin-top: 2px;' size="4" ></input>
      <p style='float: left;margin-right: 5px;margin-top: 3px;font-size: 18px'>人</p>
      <button type='button' class='btn btn-success btn-flat' onclick='saveFun()'>儲存</button>
      <br>
      <br>
      <input type="hidden" name="mode" id="mode" value=""></input>
    </form>
   
    <form action="<?php echo base_url();?>Volunteer_select/Volunteer_select_others_edit/<?php echo $vcid;?>" method="POST" id="sentd" target="_blank">
       <table id="main_table" width="100%">
          <thead>
            <tr>
                <th>
                  星期
                </th>
                <th>
                  星期一
                </th>
                <th>
                  星期二
                </th>
                <th>
                  星期三
                </th>
                <th>
                  星期四
                </th>
                <th>
                  星期五
                </th>
                <th>
                  星期六
                </th>
                <th>
                  星期日
                </th>
            </tr>
          </thead>
          <tbody>
            <?php
              if(isset($year) && isset($month) && !empty($year) && !empty($month)){
                if($first_week_day == '0'){
                  $first_week_day = 7;
                }
                $row = ceil(($month_days + $first_week_day - 1)/7);
                $first_day = ($year+1911).'-'.$month.'-01';
                $last_day = date('Y-m-t',strtotime($first_day));
                $first_column = date('Y/m/d',strtotime($first_day.'-'.$first_week_day.' day')); 
                for($i=0;$i<$row;$i++){
                  echo '<tr>';
                  echo '<td>日期</td>';
                  for($j=1;$j<=7;$j++){
                    echo '<td>'.(date('Y',strtotime($first_column.'+'.($j+($i*7)).' day'))-1911).'/'.date('m/d',strtotime($first_column.'+'.($j+($i*7)).' day')).'</td>';
                  }
                  echo '</tr>';
                  echo '<tr>';
                  echo '<td>上午</td>';
                  for($j=1;$j<=7;$j++){
                    $tmp_first_column = date('Y/m/d',strtotime($first_day.'-'.$first_week_day.' day')); 
                    $tmp_date = strtotime($tmp_first_column.'+'.($j+($i*7)).' day');
                    if($tmp_date >= strtotime($first_day) && $tmp_date <= strtotime($last_day)){
                        if(isset($num_got_it_list[$tmp_date][1]['num_got_it'])){
                          echo '<td><button type="button" class="btn btn-success btn-flat" onclick="selectFun(1,'.$tmp_date.')">選員</button>';
                          echo '正取'.htmlspecialchars($num_got_it_list[$tmp_date][1]['num_got_it'], ENT_HTML5|ENT_QUOTES).'人';
                          echo '</td>';
                        } else {
                          echo '<td><button type="button" class="btn btn-success btn-flat" onclick="selectFun(1,'.$tmp_date.')">選員</button></td>';
                        }
                    } else {
                      echo '<td style="background-color:grey"></td>';
                    }
                    
                  }
                  echo '</tr>';
                  echo '<tr>';
                  echo '<td>下午</td>';
                  for($j=1;$j<=7;$j++){
                    $tmp_first_column = date('Y/m/d',strtotime($first_day.'-'.$first_week_day.' day')); 
                    $tmp_date = strtotime($tmp_first_column.'+'.($j+($i*7)).' day');
                    if($tmp_date >= strtotime($first_day) && $tmp_date <= strtotime($last_day)){
                      if(isset($num_got_it_list[$tmp_date][2]['num_got_it'])){
                        echo '<td><button type="button" class="btn btn-success btn-flat" onclick="selectFun(2,'.$tmp_date.')">選員</button>';
                        echo '正取'.htmlspecialchars($num_got_it_list[$tmp_date][2]['num_got_it'], ENT_HTML5|ENT_QUOTES).'人';
                        echo '</td>';
                      } else {
                        echo '<td><button type="button" class="btn btn-success btn-flat" onclick="selectFun(2,'.$tmp_date.')">選員</button></td>';
                      }
                    } else {
                      echo '<td style="background-color:grey"></td>';
                    }
                  }
                  echo '</tr>';
                }
              }
            ?>
          </tbody>
       </table>
       <input type="hidden" id="type" name="type" value=""></input>
       <input type="hidden" id="date" name="date" value=""></input>
    </form>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
  function sentFun() {
    var obj = document.getElementById('sentq');
    obj.submit();
  }

  function selectFun(type,course_date){
    var obj = document.getElementById('sentd');
    document.getElementById('type').value = type;
    document.getElementById('date').value = course_date;
    obj.submit();
  }

  function saveFun(){
    var obj = document.getElementById('sentq');
    document.getElementById('mode').value = 'setting';
    obj.submit();
  }
</script>