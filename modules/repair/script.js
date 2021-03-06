function initRepairGet() {
  var o = {
    get: function() {
      return "id=" + $E("id").value + "&" + this.name + "=" + this.value;
    },
    onSuccess: function() {
      topic.valid();
      product_no.valid();
    },
    onChanged: function() {
      $E("inventory_id").value = 0;
      topic.reset();
      product_no.reset();
    }
  };
  var topic = initAutoComplete(
    "topic",
    WEB_URL + "index.php/inventory/model/autocomplete/find",
    "topic,product_no",
    "find",
    o
  );
  var product_no = initAutoComplete(
    "product_no",
    WEB_URL + "index.php/inventory/model/autocomplete/find",
    "product_no,topic",
    "find",
    o
  );
}

function initRepairDownload(id) {
  var doDelete = function() {
    if (confirm(trans("You want to XXX ?").replace(/XXX/, trans("delete")))) {
      send(
        "index.php/repair/model/detail/action",
        "id=" + this.id,
        doFormSubmit,
        this
      );
    }
  };
  forEach($G(id).elems("a"), function() {
    if (/^delete_([a-z0-9]+)$/.test(this.id)) {
      callClick(this, doDelete);
    }
  });
}