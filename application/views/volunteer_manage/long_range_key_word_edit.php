<?php

$id = isset($id)?$id:null;
$key_word = isset($key_word)?$key_word:null;
$apply_start = isset($apply_start)?$apply_start:null;
$apply_end = isset($apply_end)?$apply_end:null;

$act = '新增';
if($id)
    $act = '編輯';

?>

<div class="row">
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h1 class="box-title">
                <?php echo $act.'關鍵字'.($id?':'.$key_word:null) ?>
            </h1>
        </div>
        <div class="box-body">
            <div>
                <div id="main_div" class="special_scrollbar" style="overflow-x: auto;">
                <form action="<?php echo base_url('/volunteer_manage/long_range_key_word_save') ?>" method="POST">
                    <input type="hidden" name="id" value="<?=$id?>">
                    <label>關鍵字</label>
                    <?php 
                        $input = new input_builder('text','key_word',$key_word);
                        $input->print_html();
                    ?>
                    <label>報名日期(起)</label>
                    <?php 
                        $input = new input_builder('date','apply_start',$apply_start);
                        $input->print_html();
                    ?>
                    <label>報名日期(迄)</label>
                    <?php 
                        $input = new input_builder('date','apply_end',$apply_end);
                        $input->print_html();
                    ?>
                    <br><br>
                    <div style="width: 100%;text-align: right;padding-right: 20px">
                        <button>儲存</button>                        
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
