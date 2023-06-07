<style>
  #main_table th{
    text-align: center;
    background-color: #dd4b39;
    color: white;
    font-size: 16px;
    font-weight: 600;
    padding: 5px;
  }
</style>


<script type="text/javascript">
</script>
<?php 
$WEEK_INDEX = array(
  0 => '日',
  1 => '一',
  2 => '二',
  3 => '三',
  4 => '四',
  5 => '五',
  6 => '六',
);



?>

<div class="row">
<div class="col-xs-12">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">志工報名</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-4" style="text-align: left">
          <button>《上一週</button>
        </div>        
        <div class="col-md-4">
          
        </div>        
        <div class="col-md-4" style="text-align: right">
          <button>下一週》</button>
        </div>        
      </div>
      <table id="main_table" width="100%">
        <thead>
          <tr>
            <th>
              志工<br>類別
            </th>
            <th>
              場地
            </th>
            <?php 
            foreach ($week_list as $key => $date)
            {
              echo '
              <th class="week_title " date_no_in_pre_week="'.$key.'">
                <span class="date">'.$date.'</span><br>
                ('.$WEEK_INDEX[$key].')
              </th>
              ';
              
            }
            ?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              A
            </td>
            <td>
              A
            </td>
            <td>
              A
            </td>
            <td>
              A
            </td>
            <td>
              A
            </td>
            <td>
              D
            </td>
            <td>
              F
            </td>
            <td>
              V
            </td>
            <td>
              WW
            </td>
          </tr>
          <tr>
            <td>
              A
            </td>
            <td>
              A
            </td>
            <td>
              A
            </td>
            <td>
              A
            </td>
            <td>
              A
            </td>
            <td>
              D
            </td>
            <td>
              F
            </td>
            <td>
              V
            </td>
            <td>
              WW
            </td>
          </tr>
          <tr>
            <td>
              A
            </td>
            <td>
              A
            </td>
            <td>
              A
            </td>
            <td>
              A
            </td>
            <td>
              A
            </td>
            <td>
              D
            </td>
            <td>
              F
            </td>
            <td>
              V
            </td>
            <td>
              WW
            </td>
          </tr>
          <tr>
            <td>
              A
            </td>
            <td>
              A
            </td>
            <td>
              A
            </td>
            <td>
              A
            </td>
            <td>
              A
            </td>
            <td>
              D
            </td>
            <td>
              F
            </td>
            <td>
              V
            </td>
            <td>
              WW
            </td>
          </tr>
        <?php 

        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

