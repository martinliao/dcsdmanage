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
 <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
 <script>
  $( function() {
    var availableTags = [<?php echo '"' . implode ('","', $name_array) . '"'; ?>];
    
    $( "#names" ).autocomplete({
      minLength: 0,
      source: availableTags,
       // disabledfalse : true ,

    });
    $('#names').focus(function () {
             if (this.value == "") {
                 $(this).autocomplete("search");
             }
         });
  } );


  </script>

<div class="row">
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">E.服務時數統計表-志工服務簽到退紀錄表</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div>
                <form id="post_form" method="POST" action="<?php echo base_url(array('Volunteer_sign_report','Volunteer_sign_report_output')) ;?>">
                    <select name="year">
                    <?php 
                        $y = date('Y')-1911;

                        for($i=0;$i<5;$i++){
                          echo '<option values="'.($y+$i).'">'.($y+$i).'</option>';
                        }
                    ?>
                    </select>
                    年
                    <select name="month_start">
                    <?php 
                        for ($m=1; $m <= 12; $m++)
                        { 
                            echo '<option value="'.str_pad($m,2,'0',STR_PAD_LEFT).'" '.((date('m'))==$m?'selected':null).'>'.str_pad($m,2,'0',STR_PAD_LEFT).'</option>';
                        }
                    ?>
                    </select>
                    月
                    &emsp;
                    至
                    &emsp;
                    <select name="month_end">
                    <?php 
                        for ($m=1; $m <= 12; $m++)
                        { 
                            echo '<option value="'.str_pad($m,2,'0',STR_PAD_LEFT).'" '.((date('m'))==$m?'selected':null).'>'.str_pad($m,2,'0',STR_PAD_LEFT).'</option>';
                        }
                    ?>
                    </select>
                    月
                    <br>
                    <br>
                    姓名：<input type="text" id="names" name="firstname" value=""></input>
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
      $("input[type=checkbox]:checked").each(function () {
        if($(this).val() == 'all'){
          location.href = "<?php echo base_url();?>files/all.xlsx"
        } else if($(this).val() == '1'){
          location.href = "<?php echo base_url();?>files/category1.xlsx";
        } else if($(this).val() == '2'){
          location.href = "<?php echo base_url();?>files/category2.xlsx";
        } 
      });
    }

    function checkFun(){
      obj = document.getElementById('post_form');

      var check=$("input[name='category[]']:checked").length;//判斷有多少個方框被勾選

      if(check==0){
        alert("您未勾選任何類別");

        return false;
      }

      if(document.getElementById('names').value == ''){
        alert('姓名不能為空');
        
        return false;
      } else {
         obj.submit();
      }
      
    }
</script>