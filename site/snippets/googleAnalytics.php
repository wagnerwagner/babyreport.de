<?php if (option('googleAnaltics.trackingId')): ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-131152001-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-131152001-1', {
    'anonymize_ip': true,
  });
</script>
<?php endif; ?>
