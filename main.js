document.addEventListener('DOMContentLoaded', function() {
  var sortableBewerbung = new Sortable(document.getElementById('sortable-bewerbung'), {
    group: 'shared',
    animation: 150,
    onEnd: function(event) {
      var itemEl = event.item;
      var itemId = itemEl.dataset.id;
      var newStatus = itemEl.parentNode.id.split('-')[1];
      updateStatus(itemId, newStatus);
    }
  });

  var sortableAngeschaut = new Sortable(document.getElementById('sortable-angeschaut'), {
    group: 'shared',
    animation: 150,
    onEnd: function(event) {
      var itemEl = event.item;
      var itemId = itemEl.dataset.id;
      var newStatus = itemEl.parentNode.id.split('-')[1];
      updateStatus(itemId, newStatus);
    }
  });

  var sortableEingestellt = new Sortable(document.getElementById('sortable-eingestellt'), {
    group: 'shared',
    animation: 150,
    onEnd: function(event) {
      var itemEl = event.item;
      var itemId = itemEl.dataset.id;
      var newStatus = itemEl.parentNode.id.split('-')[1];
      updateStatus(itemId, newStatus);
    }
  });

  var sortableAbgelehnt = new Sortable(document.getElementById('sortable-abgelehnt'), {
    group: 'shared',
    animation: 150,
    onEnd: function(event) {
      var itemEl = event.item;
      var itemId = itemEl.dataset.id;
      var newStatus = itemEl.parentNode.id.split('-')[1];
      updateStatus(itemId, newStatus);
    }
  });

  function updateStatus(itemId, newStatus) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'updateStatus.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          console.log('Status erfolgreich aktualisiert');
        } else {
          console.error('Fehler beim Aktualisieren des Status: ' + xhr.status);
        }
      }
    };
    console.log('Senden von itemId: ' + itemId + ', neuer Status: ' + newStatus);
    xhr.send('itemId=' + itemId + '&newStatus=' + newStatus);
  }
});