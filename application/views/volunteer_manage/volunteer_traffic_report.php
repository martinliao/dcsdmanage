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
            <h3 class="box-title">E.服務時數統計表-志工餐點與交通補助清冊</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div>
                <form id="post_form" method="POST" action="<?php echo base_url(array('Volunteer_sign_report','volunteer_traffic_report_output')) ;?>">
                    <select name="year">
                    <?php 
                        $y = date('Y')-1911;

                        for($i=0;$i<5;$i++){
                          echo '<option values="'.($y+$i).'">'.($y+$i).'</option>';
                        }
                    ?>
                    </select>
                    年
               
                    &emsp;
                    <select name="month">
                      <option value="1-3">1-3</option>
                      <option value="4-6">4-6</option>
                      <option value="7-9">7-9</option>
                      <option value="10-12">10-12</option>
                    </select>
                    月
                    <br>
                    <br>
                    <div>
                    <label><input type="checkbox" name="category[]" value="all" class="all vID">全部</label>&emsp;
                    <label><input type="checkbox" name="category[]" value="1" class="vID">班務</label>&emsp;
                    <?php
                        for($i=0;$i<count($category);$i++) { 
                            echo '<label><input type="checkbox" name="category[]" value="'.$category[$i]->id.'" class="vID">'.$category[$i]->name.'</label>&emsp;';
                        }
                    ?>
                    <br>
                    <br>
                    <button type="button" onclick="checkFun()" class='btn btn-success btn-flat' >下載</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

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
    
    function downloadFun(){
      location.href = "<?php echo base_url();?>files/traffic.xlsx"
    }

    function checkFun(){
      obj = document.getElementById('post_form');

      var check=$("input[name='category[]']:checked").length;//判斷有多少個方框被勾選

      if(check==0){
        alert("您未勾選任何類別");

        return false;
      }

      obj.submit();
    }
</script>