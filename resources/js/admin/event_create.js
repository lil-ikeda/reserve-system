// イベント作成時にサムネイル画像のプレビューをする
export function setImage(e) {

  let file = e.target.files[0];
  let reader = new FileReader();
  let preview = document.getElementsByClassName('preview')[0]
  let previewImage = document.getElementById('event-preview-image')

  // 既にプレビュー画像がある場合は一度リセット
  if (previewImage != null) {
    preview.removeChild(previewImage);
  }

  reader.onload = function(e) {
    let img = document.createElement('img');
    img.setAttribute('src', reader.result);
    img.setAttribute('id', 'event-preview-image');
    preview.appendChild(img);
  }

  reader.readAsDataURL(file);
}

export function deleteConfirm() {
  let checked = confirm('本当に削除しますか？')
  if (checked == true) {
      return true;
  } else {
      return false;
  }
}

export function cancelConfirm() {
  let checked = confirm("本当に削除しますか？\n返金処理は完了していますか？")
  if (checked == true) {
      return true;
  } else {
      return false;
  }
}

export function paidConfirm() {
  let checked = confirm("本当に「支払済」にしますか？\n支払いは完了していますか？")
  if (checked == true) {
      return true;
  } else {
      return false;
  }
}