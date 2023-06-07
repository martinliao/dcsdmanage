<script type="text/javascript">
  $(function () {
    $('#example2').dataTable({
      oLanguage:  {
              "sProcessing": "處理中...",
              "sLengthMenu": "",
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
        paging: false,
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
      <h3 class="box-title"><?php echo $category->name.'志工';?></h3>
      <br>
      <br>
      <h4 class="box-title">
      <?php 
        if($type == '1'){
          $type_name = '上午';
        } else if($type == '2'){
          $type_name = '下午';
        }
        echo (date('Y',$date)-1911).'年'.date('m',$date).'月'.date('d',$date).'日  '.$type_name; 
      ?>
      </h4>
    </div><!-- /.box-header -->
    <div class="box-body">
    
      <?php if(isset($persons) && !empty($persons)){ ?>
        <form action="<?php echo base_url();?>Volunteer_select/Volunteer_others_add" method="POST" target="_blank">
          <input type="hidden" name="add_vid" id="add_vid" value="<?php echo htmlspecialchars($persons[0]->id,ENT_HTML5|ENT_QUOTES);?>"></input>
          <input type="hidden" name="add_name" id="add_name" value="<?php echo htmlspecialchars($category->name,ENT_HTML5|ENT_QUOTES);?>"></input>
          <input type="hidden" name="add_date" value="<?php echo htmlspecialchars($date,ENT_HTML5|ENT_QUOTES);?>"></input>
          <input type="hidden" name="add_type" value="<?php echo htmlspecialchars($type,ENT_HTML5|ENT_QUOTES);?>"></input>
          <button type='submit' class='btn btn-success btn-flat' style='margin-left: 5px'>新增志工</button>
        </form>
        <br>
      <?php } ?>
   


    <form action="<?php echo base_url();?>Volunteer_select/Volunteer_select_others_edit/<?php echo $vcid;?>" method="POST" id="saveq">
      <?php if(isset($persons) && !empty($persons)){ ?>
      <p style="float: left;margin-top: 3px;margin-right: 5px;">正取人數：</p>
      <input type="text" name="num_got_it" id="num_got_it" value="<?php echo $persons[0]->num_got_it; ?>" style="width: 35px"></input>人
      <br>
      <br>
      <!-- <p style="float: left;margin-top: 3px;margin-right: 5px;">備取人數：</p>
      <input type="text" name="num_waiting" value="<?php echo $persons[0]->num_waiting; ?>" style="width: 35px" disabled></input>人 -->
      <br>
      <br>
      <button type='button' class='btn btn-success btn-flat' style='float: right;margin-top: 3px;margin-right: 5px;' onclick='saveFun()'>儲存</button>
      <table id="example2" class="table table-bordered table-hover" style="text-align:center;vertical-align:middle">
        <thead>
          <tr>
            <th style="text-align:center;">序號</th>
            <th style="text-align:center;">姓名</th>
            <th style="text-align:center;">選員否</th>
           </tr> 
        </thead>
        <tbody>
        <?php 
            for($i=0;$i<count($detail);$i++){
              echo '<tr>
                      <td style="vertical-align:middle">'.($i+1).'</td>
                      <td style="vertical-align:middle">'.$detail[$i]->name.'</td>';
                      
              if($detail[$i]->got_it == '1'){
                echo '<td style="vertical-align:middle">
                        <select name="user_'.$detail[$i]->aid.'">
                          <option value="1" selected>正取</option>
                          <option value="-1">取消</option>
                        </select>
                      </td>';
              } else if($detail[$i]->got_it == '0') {
                echo '<td style="vertical-align:middle">
                        <select name="user_'.$detail[$i]->aid.'">
                          <option value="1">正取</option>
                          <option value="0" selected>備取</option>
                          <option value="-1">取消</option>
                        </select>
                      </td>'; 
              }        
              echo  '</tr>';
            }  
        ?>
        </tbody>
      </table>
      <input type="hidden" name="vid" id="vid" value="<?php echo $persons[0]->id;?>"></input>
      <input type="hidden" name="date" value="<?php echo $date;?>"></input>
      <input type="hidden" name="type" value="<?php echo $type;?>"></input>
      <input type="hidden" name="mode2" id="mode2" value=""></input>
      </form>
      <?php } ?>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
  function searchFun(){
    var obj = document.getElementById('searchq');
    document.getElementById('mode').value = "search";
    obj.submit();
  }

  function saveFun(){
    var obj = document.getElementById('saveq');
    var k = 0;
    var num_got_it = document.getElementById('num_got_it').value;
    document.getElementById('mode2').value = "save";

    $("#example2").find(":selected").each(function() {
        if(this.value == '1'){
          k = k + 1;
        }
    });

    if(k>num_got_it){
      alert('正取人數大於限制');
      return false;
    }

    var x = confirm('設定取消後即刪除該志工報名資料，並由第一順序備取志工自動遞補，是否繼續?');
    if(x){
      obj.submit();
    }
  }
</script>