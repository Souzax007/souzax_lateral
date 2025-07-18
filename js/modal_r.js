function setupAvatarModal() {
  const modal = document.getElementById('avatarModal');
  const openBtn = document.getElementById('openAvatarModal');
  const closeBtn = document.getElementById('closeModal');
  const avatarOptions = document.querySelectorAll('.avatar-option');
  const selectedAvatarInput = document.getElementById('selectedAvatar');
  const previewAvatar = document.getElementById('previewAvatar');

  if (!modal || !openBtn || !closeBtn || avatarOptions.length === 0 || !selectedAvatarInput || !previewAvatar) {
    return;
  }

  openBtn.addEventListener('click', () => {
    modal.style.display = 'block';
  });

  closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
  });

  avatarOptions.forEach(option => {
    option.addEventListener('click', () => {
      avatarOptions.forEach(o => o.classList.remove('selected'));
      option.classList.add('selected');

      const avatarPath = option.getAttribute('data-avatar');
      selectedAvatarInput.value = avatarPath;
      previewAvatar.src = avatarPath;
      previewAvatar.style.display = 'inline-block';
      modal.style.display = 'none';
    });
  });

  window.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.style.display = 'none';
    }
  });
}
