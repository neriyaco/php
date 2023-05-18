<?php

if (!defined('GUARD')) {
  http_response_code(404);
  exit;
}
?>
<footer class="footer">
  <script>
    /**
     * @param {HTMLElement} element
     */
    function popup(element) {
      const popupElement = document.createElement('div');
      popupElement.classList.add('popup');
      const popupCard = document.createElement('div');
      popupCard.classList.add('popup-card');
      // Add X button
      const closeButton = document.createElement('button');
      closeButton.innerText = 'X';
      closeButton.classList.add('close-button');
      closeButton.addEventListener('click', () => {
        popupElement.remove();
      });
      popupCard.appendChild(closeButton);
      popupCard.appendChild(element);
      popupElement.appendChild(popupCard);
      popupElement.addEventListener('click', (event) => {
        if (event.target === popupElement) {
          popupElement.remove();
        }
      });
      document.body.appendChild(popupElement);
    }
  </script>
</footer>