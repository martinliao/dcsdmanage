<script type="text/javascript">
  $(function () {
    $('#example2').dataTable({
      oLanguage:  {
              "sProcessing": "處理中...",
              "sLengthMenu": "顯示 _MENU_ 筆記錄 <button type='button' class='btn btn-success btn-flat' onclick='sentFun()'>確定</button>",
              "sZeroRecords": "<font color='red'>目前無您可管理的資料</font>",
              "sInfo": "目前記錄：_START_ 至 _END_, 總筆數：_TOTAL_",
              "sInfoEmpty": "無任何資料",
              "sInfoFiltered": "(過濾總筆數 _MAX_)",
              "sInfoPostFix": "",
              "sSearch": "搜尋",
              "sUrl": "",
              "oPaginate": {
                  "sFirst":    "首頁",
                  "sPrevious": "上頁",
                  "sNext":     "下頁",
                  "sLast":     "末頁"
              }
          },
        deferRender: true,
        searching: false,
        bSort: false,  
        select:{
            style:'single',
            blurable: true
        }
    });
  });
</script>

<div class="row">
<div class="col-xs-12">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">A.排班時間設定-班務志工</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
    <form action="<?php echo base_url();?>volunteer_manage/scheduling_setup" method="GET" id="sentq">
      <select class='form-control input-sm' style='width: auto;float: left;margin-top: 2px' name='year'>

      <?php
        /*
        $y = date('Y')-1911;       
        for($i=0;$i<5;$i++){
          echo '<option values="'.($y+$i).'" '.($year==$y+$i?'selected="selected"':null).'>'.($y+$i).'</option>';
        }
        */
        //mark 2021-06-10 修改A排班系統選單
        $y = date('Y')-1911;
        if(empty($year)){
          $year = $y;
        }
          echo '<option values="'.($y+1).'">'.($y+1).'</option>';
        for($i=0;$i<5;$i++){
          echo '<option values="'.($y-$i).'" '.($year==$y-$i?'selected="selected"':null).'>'.($y-$i).'</option>';

        }
      ?>
      </select>
      <p style='float: left;margin-top: 5px'>年</p>
      <select class='form-control input-sm' name='month' style='width: auto;float: left;margin-top: 2px'>
        <option values='1' <?=($month==1?'selected="selected"':null)?>>1</option>
        <option values='2' <?=($month==2?'selected="selected"':null)?>>2</option>
        <option values='3' <?=($month==3?'selected="selected"':null)?>>3</option>
        <option values='4' <?=($month==4?'selected="selected"':null)?>>4</option>
        <option values='5' <?=($month==5?'selected="selected"':null)?>>5</option>
        <option values='6' <?=($month==6?'selected="selected"':null)?>>6</option>
        <option values='7' <?=($month==7?'selected="selected"':null)?>>7</option>
        <option values='8' <?=($month==8?'selected="selected"':null)?>>8</option>
        <option values='9' <?=($month==9?'selected="selected"':null)?>>9</option>
        <option values='10' <?=($month==10?'selected="selected"':null)?>>10</option>
        <option values='11' <?=($month==11?'selected="selected"':null)?>>11</option>
        <option values='12' <?=($month==12?'selected="selected"':null)?>>12</option>
      </select>
      <p style='float: left;margin-top: 5px'>月</p>
    </form>
      <table id="example2" class="table table-bordered table-hover" style="text-align:center;vertical-align:middle">
        <thead>
          <tr>
            <th style="text-align:center;">開課起日</th>
            <th style="text-align:center;">班期代碼</th>
            <th style="text-align:center;">期別</th>
            <th style="text-align:center;">班期名稱</th>
            <th style="text-align:center;">是否為長期班</th>
            <th style="text-align:center;">是否需要志工</th>
            <th style="text-align:center;">設定</th>
           </tr> 
        </thead>
        <tbody>
        <?php 
          for($i=0;$i<count($list);$i++){
            if($list[$i]->need == '1'){
              $need = '是';
            } else {
              $need = '否';
            }

            if($list[$i]->change == '1'){
              $change = 'color:red;';
            } else {
              $change = '';
            }

            echo '<tr>
                    <td style="vertical-align:middle">'.$list[$i]->start_date.'</td>
                    <td style="vertical-align:middle">'.$list[$i]->class_no.'</td>
                    <td style="vertical-align:middle">'.$list[$i]->term.'</td> 
                    <td style="vertical-align:middle;'.$change.'">'.$list[$i]->name.'</td>
                    <td style="vertical-align:middle">'.($list[$i]->long_range?'是':'否').'</td>                    
                    <td style="vertical-align:middle">'.$need.'</td>
                    <td style="vertical-align:middle">
                      <div class="btn-dataset">
                        <a href="'.base_url().'volunteer_manage/scheduling_setup_edit/'.$list[$i]->id.'/'.$list[$i]->need.'" title="edit" class="btn btn-default btn-xs"><i class="fa fa-pencil fa-eye"></i>設定</a>  
                      </div>
                    </td>
                  </tr>';
          }  
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
  function sentFun(){
    var obj = document.getElementById('sentq');
    obj.submit();
  }
</script>