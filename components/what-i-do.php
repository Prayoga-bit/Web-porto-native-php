<?php
$cards = [
  [
    'img' => 'img/data-analyst-icon.png',
    'alt' => 'Data analyst icon',
    'title' => 'Data Analyst',
    'text' => 'A data analyst is a professional who collects, processes, and performs statistical analyses...',
    'btn_text' => 'See My Project →',
    'btn_href' => '#'
  ],
  [
    'img' => 'img/machine-learning-icon.png',
    'alt' => 'Machine Learning icon',
    'title' => 'Machine Learning',
    'text' => 'Machine learning is a subset of artificial intelligence that focuses on building systems that learn...',
    'btn_text' => 'See My Project →',
    'btn_href' => '#'
  ],
  [
    'img' => 'img/business-flow-icon.png',
    'alt' => 'Business Flow icon',
    'title' => 'Business Flow',
    'text' => 'Business flow refers to the sequence of processes and tasks that an organization follows...',
    'btn_text' => 'Learn About It →',
    'btn_href' => '#'
  ],
];
?>

<!-- What I Do section -->
<section id="whatIDo" class="what-i-do-section mb-5">
  <div class="container d-flex flex-column">
    <div class="what-i-do-title text-center mb-5 mt-5">
      <h6>Passion led me to</h6>
      <h2 class="fw-bold">What I Do</h2>
    </div>

    <div class="what-i-do-cards d-flex flex-wrap justify-content-around">
      <?php foreach ($cards as $card): ?>
        <div class="what-i-do-card card" style="width: 18rem">
          <img src="<?php echo htmlspecialchars($card['img'], ENT_QUOTES); ?>"
               class="card-img-top"
               alt="<?php echo htmlspecialchars($card['alt'], ENT_QUOTES); ?>" />
          <div class="card-body">
            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($card['title'], ENT_QUOTES); ?></h5>
            <p class="card-text fw-regular">
              <?php echo htmlspecialchars($card['text'], ENT_QUOTES); ?>
            </p>
            <a href="<?php echo htmlspecialchars($card['btn_href'], ENT_QUOTES); ?>"
               class="what-i-do-btn btn p-0 fs-6 fw-bold mt-5 mb-4">
               <?php echo htmlspecialchars($card['btn_text'], ENT_QUOTES); ?>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
