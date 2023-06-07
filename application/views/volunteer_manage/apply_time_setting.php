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
        drawCallback:function(settings){
          $('#check_all').prop('checked',false);
        }
    });
  });
</script>

<div class="row">
<div class="col-xs-12">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">B.報名時間設定:班務</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
    <form action="<?php echo base_url();?>volunteer_manage/apply_time_setting" method="GET" id="sentq">
      <select class='form-control input-sm' style='width: auto;float: left;margin-top: 2px' name='year'>
        <?php
          $y = date('Y')-1911;

          for($i=0;$i<5;$i++){
            echo '<option values="'.($y+$i).'" '.($year == $y+$i ? 'selected="selected"':null).'>'.($y+$i).'</option>';
        }
      ?>
      </select>
      <p style='float: left;margin-top: 5px'>年</p>
      <select class='form-control input-sm' name='month' style='width: auto;float: left;margin-top: 2px'>
        <option values='1' <?=($month == 1 ? 'selected="selected"':null)?>>1</option>
        <option values='2' <?=($month == 2 ? 'selected="selected"':null)?>>2</option>
        <option values='3' <?=($month == 3 ? 'selected="selected"':null)?>>3</option>
        <option values='4' <?=($month == 4 ? 'selected="selected"':null)?>>4</option>
        <option values='5' <?=($month == 5 ? 'selected="selected"':null)?>>5</option>
        <option values='6' <?=($month == 6 ? 'selected="selected"':null)?>>6</option>
        <option values='7' <?=($month == 7 ? 'selected="selected"':null)?>>7</option>
        <option values='8' <?=($month == 8 ? 'selected="selected"':null)?>>8</option>
        <option values='9' <?=($month == 9 ? 'selected="selected"':null)?>>9</option>
        <option values='10' <?=($month == 10 ? 'selected="selected"':null)?>>10</option>
        <option values='11' <?=($month == 11 ? 'selected="selected"':null)?>>11</option>
        <option values='12' <?=($month == 12 ? 'selected="selected"':null)?>>12</option>
      </select>
      <p style='float: left;margin-top: 5px'>月</p>
    </form>
        <table id="example2" class="table table-bordered table-hover" style="text-align:center;vertical-align:middle">
          <thead>
            <tr>
              <td colspan="7" align="right">
                <form id="post_form" method="POST" action="<?php echo base_url('volunteer_manage/apply_time_setting_save') ?>">
                    批次設定 報名日期限制：起
                  <?php
                    $input = new input_builder('date','apply_start',$first_day);
                    $input->set_style('display:inline-block;width:180px')
                          ->print_html();
                  ?>
                  迄
                  <?php
                    $input = new input_builder('date','apply_end',$last_day);
                    $input->set_style('display:inline-block;width:180px')
                          ->print_html();
                  ?>
                  <button class="btn" style="border-color: #00000078">送出</button>
                </form>
              </td>
            </tr>

            <tr>
              <th style="text-align:center;text-align: right;width:90px;padding-right:5px">批次設定&emsp;<input id="check_all" type="checkbox"></th>
              <th style="text-align:center;">開課起日</th>
              <th style="text-align:center;">班期代碼</th>
              <th style="text-align:center;">期別</th>
              <th style="text-align:center;">班期名稱</th>
              <th style="text-align:center;">報名時間</th>
              <th style="text-align:center;">限額時間</th>
              <th style="text-align:center;">是否為長期班</th>
              <th style="text-align:center;">設定</th>
             </tr> 
          </thead>
          <tbody>
          <?php 
            for($i=0;$i<count($list);$i++){
              echo '<tr>
                      <td style="vertical-align:middle;text-align: right;padding-right:5px"><input class="view_checkbox" type="checkbox" name="courseID['.$list[$i]->id.']" value="1"></td>
                      <td style="vertical-align:middle">'.$list[$i]->start_date.'</td>
                      <td style="vertical-align:middle">'.$list[$i]->class_no.'</td>
                      <td style="vertical-align:middle">'.$list[$i]->term.'</td> 
                      <td style="vertical-align:middle">'.$list[$i]->name.'</td>
                      <td style="vertical-align:middle">'.($list[$i]->apply_start && $list[$i]->apply_end?$list[$i]->apply_start.'~'.$list[$i]->apply_end.' '.'':'-').'</td>
                      <td style="vertical-align:middle">'.($list[$i]->limit_start && $list[$i]->limit_end?$list[$i]->limit_start.'~'.$list[$i]->limit_end.' '.'':'-').'</td>
                      <td style="vertical-align:middle">'.($list[$i]->long_range?'是':'否').'</td>
                      <td style="vertical-align:middle">
                        <div class="btn-dataset">
                          <a href="'.base_url().'volunteer_manage/apply_time_setting_edit/'.$list[$i]->id.'/'.$list[$i]->need.'" title="edit" class="btn btn-default btn-xs"><i class="fa fa-pencil fa-eye"></i>設定</a>  
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
  $('.view_checkbox').on('change',function(){
    var name = $(this).attr('name');
    console.log($(this));
    if($(this).prop('checked'))
    {
      var clone = $(this).clone().removeClass('view_checkbox').addClass('post_checkbox').attr('type','hidden');
      $('#post_form').append(clone);
      var clone2 = $(this).clone().removeClass('view_checkbox').addClass('post_checkbox').attr('type','hidden');
      $('#post_form_2').append(clone2);
    }
    else
    {
      $('.post_checkbox[name="'+name+'"]').remove();
    }
  });
  $('#check_all').on('click',function(){
    var checked = $(this).prop('checked');

    $('.view_checkbox').each(function(){
      $(this).prop('checked',checked).trigger("change");
    });
  });
  $(function(){
    $('.view_checkbox').prop('checked',false);
  });
</script>