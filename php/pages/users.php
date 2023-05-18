<?php

if (!defined('GUARD')) {
  http_response_code(404);
  exit;
}
require_once 'database/models/user.php';

$users = (new UserModel())->find();
?>


<h2>Users</h2>
<table class="striped-table">
  <thead>
    <tr>
      <th>Username</th>
      <th>Email</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    
  </tbody>
</table>

<script>
  async function loadUsers() {
    const response = await fetch('/api/users');
    const users = await response.json();
    const tableBody = document.querySelector('tbody');
    for (const user of users) {
      const row = document.createElement('tr');
      const usernameCell = document.createElement('td');
      usernameCell.innerText = user.username;
      usernameCell.style.cursor = 'pointer';
      usernameCell.addEventListener('click', async () => {
        const response = await fetch(`/api/users?id=${user.id}`);
        popup(userDataPopup(await response.json()));
      });
      const emailCell = document.createElement('td');
      emailCell.innerText = user.email;
      const actionsCell = document.createElement('td');
      const deleteButton = document.createElement('button');
      deleteButton.addEventListener('click', () => {
        popup(deletePopup());
      });
      deleteButton.innerText = 'Delete';
      deleteButton.dataset.userId = user.id;
      deleteButton.classList.add('delete-user');
      actionsCell.appendChild(deleteButton);
      row.appendChild(usernameCell);
      row.appendChild(emailCell);
      row.appendChild(actionsCell);
      tableBody.appendChild(row);
    }
  }

  loadUsers();

  function deletePopup() {
    const popupElement = document.createElement('div');
    popupElement.style.textAlign = 'center';
    const text = document.createElement('p');
    text.innerText = 'Are you sure you want to delete this user?';
    const confirmButton = document.createElement('button');
    confirmButton.innerText = 'Yes';
    confirmButton.addEventListener('click', () => {
      const userId = confirmButton.dataset.userId;
      fetch(`/api/users?id=${userId}`, {
        method: 'DELETE',
      }).then(() => {
        window.location.reload();
      });
    });
    popupElement.appendChild(text);
    popupElement.appendChild(confirmButton);
    return popupElement;
  }
  

  function userDataPopup(user) {
    const popupElement = document.createElement('div');
    popupElement.classList.add('user-data');
    Object.entries(user).forEach(([key, value]) => {
      const row = document.createElement('div');
      row.innerHTML = `<b>${toTitleCase(key)}</b>: ${value}`;
      row.classList.add('user-data-row');
      popupElement.appendChild(row);
    });
    return popupElement;
  }

  function toTitleCase(str) {
    str = str.replace('_', ' ');
    return str.replace(
      /\w\S*/g,
      (txt) => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
    );
  }
</script>

</html>