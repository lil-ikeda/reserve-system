// イベント作成時にサムネイル画像のプレビューをする
function setImage(e) {

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
