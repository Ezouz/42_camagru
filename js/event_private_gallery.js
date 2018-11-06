function fade_elem(elem) {
  if (document.getElementById(elem).classList.contains('not_faded')) {
    document.getElementById(elem).classList.remove('not_faded');
    document.getElementById(elem).classList.add('faded');
  }
};

function unfade_elem(elem) {
  if (document.getElementById(elem).classList.contains('faded')) {
    document.getElementById(elem).classList.remove('faded');
    document.getElementById(elem).classList.add('not_faded');
  }
}

function click_mask() {
  if (document.getElementById('account').classList.contains('not_faded')) {
    fade_elem('account');
    document.getElementById('gallery_posts').style.marginTop = "0%";
  }
    fade_elem('change_login');
    fade_elem('change_email');
    fade_elem('change_pwd');
    fade_elem('mask');
};

function click_account() {
    unfade_elem('mask');
  if (document.getElementById('account').classList.contains('faded')) {
    unfade_elem('account');
    document.getElementById('gallery_posts').style.marginTop = "10%";
  }
};

function click_email() {
    unfade_elem('mask');
    fade_elem('change_login');
    fade_elem('change_pwd');
    unfade_elem('change_email');
};

function click_login() {
    unfade_elem('mask');
    fade_elem('change_pwd');
    fade_elem('change_email');
    unfade_elem('change_login');
};

function click_pwd() {
    unfade_elem('mask');
    fade_elem('change_email');
    fade_elem('change_login');
    unfade_elem('change_pwd');
};
