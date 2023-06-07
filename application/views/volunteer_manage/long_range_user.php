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
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        deferRender: true,
        searching: false,
        bSort: false,  
        select:{
            style:'single',
            blurable: true
        },
    });
  });
</script>

<div class="row">
<div class="col-xs-12">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">I.長期班設定:設定長期志工</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table id="example2" class="table table-bordered table-hover" style="text-align:center;vertical-align:middle">
          <thead>
            <tr>
              <td colspan="3" style="text-align:right;">
                <div>
                  <form method="POST" action="<?php echo base_url('volunteer_manage/long_range_user_add') ?>">
                  姓名：
                  <?php 
                    $input = new input_builder('select2','userID');

                    $input->set_option(array('_disabled'=>'請選擇')+$user_list)
                          ->set_style('display:inline-block;width:200px')
                          ->print_html();
                  ?>
                  <button type="submit" class="btn">加入</button>
                  </form>
                </div>
              </td>
            </tr> 
            <tr>
              <th style="text-align:center;">序號</th>
              <th style="text-align:center;">姓名</th>
              <th style="text-align:center;">設定</th>
            </tr> 
          </thead>
          <tbody>
          <?php 
            $i = 0;
            foreach ($users as $each)
            {
              echo '
                <tr>
                  <td style="text-align:center;">'.++$i.'</td>
                  <td style="text-align:center;">'.$each->name.'</td>
                  <td>
                    <div class="btn-dataset">
                      <a href="#" onclick="remove_data(\''.base_url().'volunteer_manage/long_range_user_remove/\',{\'userID\':\''.$each->id.'\'})" title="edit" class="btn btn-default btn-xs"><i class="fa fa-trash fa-trash"></i>&nbsp;&nbsp;刪除</a>
                    </div>
                  </td>
                 </tr> 
              ';
              
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

  function remove_data(url,data){
    $.post(url,data,function(response){
      json = $.parseJSON(response);
      alert(json.msg);
      location.reload();
    });
  }
</script>