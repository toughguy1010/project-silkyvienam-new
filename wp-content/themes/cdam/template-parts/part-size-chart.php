<?php
$homeID = get_option('page_on_front');
$homeFields = get_field_objects( $homeID );

$sizechart = $homeFields['zwc_size_chart']['value'];
?>
<div id="size-chart">
  <div class="wrap-size-chart">
    <div class="title">
      <?php echo apply_filters('acf_the_content',$sizechart['title']); ?>
    </div>
    <div class="subtitle">
      <?php echo apply_filters('acf_the_content',$sizechart['subtitle']); ?>
    </div>
    <div class="wrap-table-sizechart">
      <?php
      // print_r($sizechart['content']);
      foreach ($sizechart['content'] as $group) {
        ?>
        <table>
          <?php
          foreach ($group['group'] as $unit) {
            ?>
            <tr>
              <?php
              for ($i=0; $i < $sizechart['col']; $i++) {
                ?>
                <td style="width:calc(100% / <?php echo $sizechart['col']; ?>);"><?php echo apply_filters('acf_the_content', $unit['unit'][$i]['item'] ? $unit['unit'][$i]['item'] : ''); ?></td>
                <?php
              }
              ?>
            </tr>
            <?php
          }
          ?>
        </table>
        <?php
      }
      ?>
    </div>
  </div>
  <span class="close"><img src="<?php echo get_template_directory_uri().'/assets/close-b.svg' ?>" /></span>
</div>
