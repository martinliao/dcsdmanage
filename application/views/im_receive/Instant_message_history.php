<script type="text/javascript">
  $(function () {
    $('#example2').dataTable({
      oLanguage:  {
              "sProcessing": "處理中...",
              "sLengthMenu": "",
              "sZeroRecords": "<font color='red'>目前無資料</font>",
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
        bSort: false,  
        deferRender: true,
        lengthMenu: [[5], [5]],
        searching: false,
        select:{
            style:'single',
            blurable: true
        }
    });
  });

  function CheckTaiwanID(idno) { //身份證檢查函式
    var reg=/^[A-Z]{1}[1-2]{1}[0-9]{8}$/;  //身份證的正規表示式
    if( reg.test( idno ) ) {
        var s = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";  //把A取代成10,把B取代成11...的作法
        var ct = ["10","11","12","13","14","15","16","17","34","18","19","20","21",
                       "22","35","23","24","25","26","27","28","29","32","30","31","33"];
        var i = s.indexOf(idno.charAt(0));
        var tempuserid = ct[i] + idno.substr(1, 9); //若此身份證號若是A123456789=>10123456789
        var num = tempuserid.charAt(0)*1;
        for( i=1 ; i<=9 ; i++ ) {
           num = num + tempuserid.charAt(i)*(10-i);
        }
        num += tempuserid.charAt(10)*1;
 
        if( (num%10)==0 ) {
           return true;
        } else {
           return false;
        }
    } else {
        return false;
    }
  }

  function sendFun(){
    var obj  = document.getElementById('sendq');
    var idno  = document.getElementById('search').value;
    idno = idno.toUpperCase();
    var check = CheckTaiwanID(idno); 

    if(check){
      obj.submit();
    } else {
      alert('身分證不合法');
    }
  }
</script>

<div class="row">
<div class="col-xs-12">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title" style="color:green;font-weight: bold;font-size: 35px"><?php echo $title; ?></h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table id="example2" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>標題</th>
            <th>寄件者</th>
            <th>日期</th>
           </tr> 
        </thead>
        <tbody>
        <?php 
          for($i=0;$i<count($message);$i++){
                if(isset($history)){
                  $path = 'http://192.168.50.29/eda/manage/Instant_message_receive/history_view/';
                } else {
                  $path = 'http://192.168.50.29/eda/manage/Instant_message_receive/receive_view/';
                }
                echo '<tr>
                      <td><a href="'.$path.$message[$i]->id.'">'.$message[$i]->title.'</a></td>
                      <td>系統管理者</td>
                      <td>'.$message[$i]->send_time.'</td> 
                    </tr>';
          }  

        ?>
         
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

