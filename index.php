<?php
require 'manager/Data.class.php';

function renderGallery($galleryId)
{
    $images = new Data('./data/images_' . $galleryId);
    $images->load();
    $output = '';
    foreach ($images->getAll() as $image) {
        $output .= '
                  <div class="b-album__item">
                      <img class="b-album__img" src="' . $image['image'] . '" alt="' . $image['title'] . '">
                      <p class="b-album__title">' . $image['title'] . '</p>
                      <p class="b-album__price">' . $image['price'] . ' грн</p>
                      <a href="#b-communications" class="b-album__link b-header__link">Замовити</a>
                      <div class="ya-share2 i" data-services="vkontakte,facebook,odnoklassniki,gplus"></div>
                  </div>
                  ';
    }
    return $output;
}


echo renderGallery(1);

echo renderGallery(2);
