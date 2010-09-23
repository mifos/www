<?php
  // deployment overview files
  $deployment_overview_files = '';
  foreach ($node->field_deployment_overview_upload as $upload) {
    $file_text = $upload['data']['description'] ? $upload['data']['description'] : $upload['filename'];
    $deployment_overview_files .= '<a href="/' . $upload['filepath'] . '">' . $file_text . '</a>, ';
  }
  
  // pre-deployment files
  $pre_deployment_files = '';
  foreach ($node->field_predeployment_analysis_upl as $upload) {
    $upload = node_load($upload['nid']);
    $file_text = $upload->title ? $upload->title : $upload->field_file_name[0]['filename'];
    $pre_deployment_files .= '<a href="/' . $upload->field_file_name[0]['filepath'] . '">' . $file_text . '</a>, ';
  }
  
  // configuration files
  $configuration_files = '';
  foreach ($node->field_configuration_upload as $upload) {
    $upload = node_load($upload['nid']);
    $file_text = $upload->title ? $upload->title : $upload->field_file_name[0]['filename'];
    $configuration_files .= '<a href="/' . $upload->field_file_name[0]['filepath'] . '">' . $file_text . '</a>, ';
  }
  
  // accounting files
  $accounting_files = '';
  foreach ($node->field_accounting_upload as $upload) {
    $upload = node_load($upload['nid']);
    $file_text = $upload->title ? $upload->title : $upload->field_file_name[0]['filename'];
    $accounting_files .= '<a href="/' . $upload->field_file_name[0]['filepath'] . '">' . $file_text . '</a>, ';
  }
  
  // infrastructure files
  $infrastructure_files = '';
  foreach ($node->field_infrastructure_upload as $upload) {
    $upload = node_load($upload['nid']);
    $file_text = $upload->title ? $upload->title : $upload->field_file_name[0]['filename'];
    $infrastructure_files .= '<a href="/' . $upload->field_file_name[0]['filepath'] . '">' . $file_text . '</a>, ';
  }
  
  // reporting files
  $reporting_files = '';
  foreach ($node->field_reporting_upload as $upload) {
    $upload = node_load($upload['nid']);
    $file_text = $upload->title ? $upload->title : $upload->field_file_name[0]['filename'];
    $reporting_files .= '<a href="/' . $upload->field_file_name[0]['filepath'] . '">' . $file_text . '</a>, ';
  }
  
  // data migration files
  $data_migration_files = '';
  foreach ($node->field_data_migration_upload as $upload) {
    $upload = node_load($upload['nid']);
    $file_text = $upload->title ? $upload->title : $upload->field_file_name[0]['filename'];
    $data_migration_files .= '<a href="/' . $upload->field_file_name[0]['filepath'] . '">' . $file_text . '</a>, ';
  }
  
  // training files
  $training_files = '';
  foreach ($node->field_training_upload as $upload) {
    $upload = node_load($upload['nid']);
    $file_text = $upload->title ? $upload->title : $upload->field_file_name[0]['filename'];
    $training_files .= '<a href="/' . $upload->field_file_name[0]['filepath'] . '">' . $file_text . '</a>, ';
  }
  
  // uat & rollout files
  $uat_rollout_files = '';
  foreach ($node->field_uat_rollout_upload as $upload) {
    $upload = node_load($upload['nid']);
    $file_text = $upload->title ? $upload->title : $upload->field_file_name[0]['filename'];
    $uat_rollout_files .= '<a href="/' . $upload->field_file_name[0]['filepath'] . '">' . $file_text . '</a>, ';
  }
  
  // post-deployment files
  $post_deployment_files = '';
  foreach ($node->field_post_deployment_upload as $upload) {
    $upload = node_load($upload['nid']);
    $file_text = $upload->title ? $upload->title : $upload->field_file_name[0]['filename'];
    $post_deployment_files .= '<a href="/' . $upload->field_file_name[0]['filepath'] . '">' . $file_text . '</a>, ';
  }
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"><div class="node-inner">

  <?php print $picture; ?>

  <?php if (!$page): ?>
    <h2 class="title">
      <a href="<?php print $node_url; ?>" title="<?php print $title ?>"><?php print $title; ?></a>
    </h2>
  <?php endif; ?>

  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>

  <div class="content">
    <a name="overview"></a>
    <?php echo $node->field_overview[0]['view'] ?>
    
    <?php if($node->field_deployment_overview[0]['value']): ?>
      <a name="deployment"></a>
      <h2>Deployment Overview</h2>
      <?php echo $node->field_deployment_overview[0]['view'] ?>
      <?php if($node->field_deployment_overview_upload[0]['nid']): ?><p><strong>Downloadable Content:</strong> <?php echo substr($deployment_overview_files, 0, -2) ?></p><?php endif ?>
    <?php endif ?>
    
    <?php if($node->field_predeployment_analysis[0]['value']): ?>
      <a name="pre_deployment"></a>
      <h2>Pre-Deployment Analysis</h2>
      <?php echo $node->field_predeployment_analysis[0]['view'] ?>
      <?php if($node->field_predeployment_analysis_upl[0]['nid']): ?><p><strong>Downloadable Content:</strong> <?php echo substr($pre_deployment_files, 0, -2) ?></p><?php endif ?>
    <?php endif ?>
    
    <?php if($node->field_configuration[0]['value']): ?>
      <a name="configuration"></a>
      <h2>Configuration</h2>
      <?php echo $node->field_configuration[0]['view'] ?>
      <?php if($node->field_configuration_upload[0]['nid']): ?><p><strong>Downloadable Content:</strong> <?php echo substr($configuration_files, 0, -2) ?></p><?php endif ?>
    <?php endif ?>
    
    <?php if($node->field_accounting[0]['value']): ?>
      <a name="accounting"></a>
      <h2>Accounting</h2>
      <?php echo $node->field_accounting[0]['view'] ?>
      <?php if($node->field_accounting_upload[0]['nid']): ?><p><strong>Downloadable Content:</strong> <?php echo substr($accounting_files, 0, -2) ?></p><?php endif ?>
    <?php endif ?>
    
    <?php if($node->field_infrastructure_details[0]['value']): ?>
      <a name="infrastructure"></a>
      <h2>Infrastructure</h2>
      <?php echo $node->field_infrastructure_details[0]['view'] ?>
      <?php if($node->field_infrastructure_upload[0]['nid']): ?><p><strong>Downloadable Content:</strong> <?php echo substr($infrastructure_files, 0, -2) ?></p><?php endif ?>
    <?php endif ?>
    
    <?php if($node->field_reporting[0]['value']): ?>
      <a name="reporting"></a>
      <h2>Reporting</h2>
      <?php echo $node->field_reporting[0]['view'] ?>
      <?php if($node->field_reporting_upload[0]['nid']): ?><p><strong>Downloadable Content:</strong> <?php echo substr($reporting_files, 0, -2) ?></p><?php endif ?>
    <?php endif ?>
    
    <?php if($node->field_data_migration[0]['value']): ?>
      <a name="data_migration"></a>
      <h2>Data Migration</h2>
      <?php echo $node->field_data_migration[0]['view'] ?>
      <?php if($node->field_data_migration_upload[0]['nid']): ?><p><strong>Downloadable Content:</strong> <?php echo substr($data_migration_files, 0, -2) ?></p><?php endif ?>
    <?php endif ?>
    
    <?php if($node->field_training[0]['value']): ?>
      <a name="training"></a>
      <h2>Training</h2>
      <?php echo $node->field_training[0]['view'] ?>
      <?php if($node->field_training_upload[0]['nid']): ?><p><strong>Downloadable Content:</strong> <?php echo substr($training_files, 0, -2) ?></p><?php endif ?>
    <?php endif ?>
    
    <?php if($node->field_uat_rollout[0]['value']): ?>
      <a name="uat_rollout"></a>
      <h2>UAT &amp; Rollout</h2>
      <?php echo $node->field_uat_rollout[0]['view'] ?>
      <?php if($node->field_uat_rollout_upload[0]['nid']): ?><p><strong>Downloadable Content:</strong> <?php echo substr($uat_rollout_files, 0, -2) ?></p><?php endif ?>
    <?php endif ?>
    
    <?php if($node->field_post_deployment_planning[0]['value']): ?>
      <a name="post_deployment"></a>
      <h2>Post-Deployment Planning</h2>
      <?php echo $node->field_post_deployment_planning[0]['view'] ?>
      <?php if($node->field_post_deployment_upload[0]['nid']): ?><p><strong>Downloadable Content:</strong> <?php echo substr($post_deployment_files, 0, -2) ?></p><?php endif ?>
    <?php endif ?>
  </div>
  
  <p><?php echo l('Submit Your Project Deployment', 'node/55') ?></p>

  <?php print $links; ?>

</div></div> <!-- /node-inner, /node -->

<?php if ($node->field_subtitle && count($node->field_subtitle) > 0): ?>
  <!-- show the subtitle, if there is one -->
  <div id="subtitle" style="display:none;">
    <h2><?php print $node->field_subtitle[0]['value']; ?></h2>
  </div> <!-- subtitle -->
<?php endif ?>
