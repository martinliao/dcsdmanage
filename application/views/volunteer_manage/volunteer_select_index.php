<script type="text/javascript">
  $(function () {
    $('#example2').dataTable({
      oLanguage:  {
              "sProcessing": "處理中...",
              "sLengthMenu": "<button type='button' class='btn btn-success btn-flat' onclick='sentFun()'>搜尋</button>",
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
      <h3 class="box-title">C.志工選員-班務志工</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
    <form action="<?php echo base_url();?>/Volunteer_select" method="POST" id="sentq">
      <p style="float: left;margin-top: 3px;margin-right: 5px">年度</p>
      <select class='form-control input-sm' name='year' style='width: auto;'>
        <?php
          $y = date('Y')-1911;

          for($i=0;$i<5;$i++){
            echo '<option values="'.($y+$i).'">'.($y+$i).'</option>';
          }
        ?>
      </select>
      <br>
      <p style="float: left;margin-top: 3px;margin-right: 5px">月份</p>
      <select class='form-control input-sm' name='month' style='width: auto'>
        <option values='1' selected="selected">1</option>
        <option values='2'>2</option>
        <option values='3'>3</option>
        <option values='4'>4</option>
        <option values='5'>5</option>
        <option values='6'>6</option>
        <option values='7'>7</option>
        <option values='8'>8</option>
        <option values='9'>9</option>
        <option values='10'>10</option>
        <option values='11'>11</option>
        <option values='12'>12</option>
      </select>
      <br>
      <p style="float: left;margin-top: 3px;margin-right: 5px">班期代碼</p>
      <input type="text" name="class_no" id="class_no" value=""></input>
      <br>
      <br>
      <p style="float: left;margin-top: 3px;margin-right: 5px">班期名稱</p>
      <input type="text" name="class_name" id="class_name" value=""></input>
      <br>
      <br>
    </form>
      <table id="example2" class="table table-bordered table-hover" style="text-align:center;vertical-align:middle">
        <thead>
          <tr>
            <th style="text-align:center;">年度</th>
            <th style="text-align:center;">班期代碼</th>
            <th style="text-align:center;">期別</th>
            <th style="text-align:center;">班期名稱</th>
            <th style="text-align:center;">選員</th>
           </tr> 
        </thead>
        <tbody>
        <?php 
          for($i=0;$i<count($list);$i++){
            echo '<tr>
                    <td style="vertical-align:middle">'.$list[$i]->year.'</td>
                    <td style="vertical-align:middle">'.$list[$i]->class_no.'</td>
                    <td style="vertical-align:middle">'.$list[$i]->term.'</td> 
                    <td style="vertical-align:middle">'.$list[$i]->name.'</td>
                    <td style="vertical-align:middle">
                      <div class="btn-dataset">
                        <a href="'.base_url().'volunteer_select/volunteer_select_edit/'.$list[$i]->id.'/" title="edit" class="btn btn-default btn-xs"><i class="fa fa-pencil fa-eye"></i>選員</a>  
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