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
      <h3 class="box-title">A.排班時間設定-<?php echo $volunteer_data->name.'志工'; ?></h3>
    </div><!-- /.box-header -->
    <div class="box-body">
    <form action="" method="POST">
      <select class='form-control input-sm' style='width: auto;float: left;margin-top: 2px' name='search[year]'>
      <?php
        /*
        $y = date('Y')-1911;
        for($i=0;$i<5;$i++){
          echo '<option values="'.($y+$i).'" '.($search['year']==$y+$i?'selected="selected"':null).'>'.($y+$i).'</option>';         
        }
        */ 
        //mark 2021-06-10 修改A排班系統選單
        $y = date('Y')-1911;
        if(empty($search['year'])){
          $search['year'] = $y;
        }
          echo '<option values="'.($y+1).'" '.($search['year']==$y+$i?'selected="selected"':null).'>'.($y+1).'</option>';
        for($i=0;$i<5;$i++){
          echo '<option values="'.($y-$i).'" '.($search['year']==$y-$i?'selected="selected"':null).'>'.($y-$i).'</option>';
        }
      ?>
      </select>
      <p style='float: left;margin-top: 5px'>年</p>
      <select class='form-control input-sm' name='search[month]' style='width: auto;float: left;margin-top: 2px'>
        <option values='1' <?=($search['month']==1?'selected="selected"':null)?> >1</option>
        <option values='2' <?=($search['month']==2?'selected="selected"':null)?> >2</option>
        <option values='3' <?=($search['month']==3?'selected="selected"':null)?> >3</option>
        <option values='4' <?=($search['month']==4?'selected="selected"':null)?> >4</option>
        <option values='5' <?=($search['month']==5?'selected="selected"':null)?> >5</option>
        <option values='6' <?=($search['month']==6?'selected="selected"':null)?> >6</option>
        <option values='7' <?=($search['month']==7?'selected="selected"':null)?> >7</option>
        <option values='8' <?=($search['month']==8?'selected="selected"':null)?> >8</option>
        <option values='9' <?=($search['month']==9?'selected="selected"':null)?> >9</option>
        <option values='10' <?=($search['month']==10?'selected="selected"':null)?> >10</option>
        <option values='11' <?=($search['month']==11?'selected="selected"':null)?> >11</option>
        <option values='12' <?=($search['month']==12?'selected="selected"':null)?> >12</option>
      </select>
      <p style='float: left;margin-top: 5px'>月</p>
      <button id="search_btn" type="submit" class="btn btn-success btn-flat">確定</button>
    </form>
    <?php 
    if($reflash)
    {
      echo '<script>$(\'#search_btn\').click();</script>';
    }
    elseif($default_form)
    {
      $this->load->view('volunteer_manage/scheduling_setup_others_from2');
    }
    ?>
    </div>
  </div>
</div>
</div>