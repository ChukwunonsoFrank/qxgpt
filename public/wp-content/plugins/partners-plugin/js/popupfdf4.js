// js/popup.js
jQuery(document).ready(function ($) {
  function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
  }

  function setCookie(name, value, days) {
    const expires = new Date();
    expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value}; path=/; expires=${expires.toUTCString()};`;
  }
  
  function showPopup(selector) {
    $('body').css('overflow', 'hidden');
    $(selector).css('display', 'flex');
    closePopupOnOutsideClick(selector); // Add outside click handler
  }

  function closePopupOnOutsideClick(selector) {
    $(selector).on('click', function (e) {
      // Check if the popup is visible and click is outside the form
      if ($(selector).css('display') !== 'none' && !$(e.target).closest('#signup-form').length) {
        $(selector).css('display', 'none');
        $('body').css('overflow', 'auto'); // Restore body scroll
      }
    });
  }

  function showPopupOnAffiliateClick(selector) {
    if (!getCookie('formSubmission') && $(selector).length) {
      $('.affiliates article').on('click', function (event) {
        event.preventDefault();
        const affiliateLink = $(this).find('a').attr('href') || '';
        const $form = $('form.tl-form');
        const baseAction = $form.attr('action') || '';
        const newAction = baseAction + (baseAction.includes('?') ? '&' : '?') + 'affiliate=' + encodeURIComponent(affiliateLink);
        $form.attr('action', newAction);
        showPopup(selector);
      });
    }
  }

  function saveFormSubmissionToCookie() {
    const formData = {
      firstname: $('input[name="firstname"]').val(),
      lastname: $('input[name="lastname"]').val(),
      email: $('input[name="email"]').val(),
      broker: $('select[name="broker"]').val(),
      other: $('input[name="other"]').val(),
      data: $('input[name="data"]').is(':checked'),
      marketing: $('input[name="marketing"]').is(':checked'),
      cookies: $('input[name="cookies"]').is(':checked')
    };
    setCookie('formSubmission', JSON.stringify(formData), 365);
  }

  function areAllCheckboxesChecked() {
    return ['data-checkbox', 'cookies-checkbox'].every((checkboxId) =>
      $(`#${checkboxId}`).is(':checked')
    );
  }

  function displayFormData(data) {
    const displayHtml = `
      <div class="form-data-display">
        <h4>Submitted Data:</h4>
        <p><strong>First Name:</strong> ${data.firstname || 'N/A'}</p>
        <p><strong>Last Name:</strong> ${data.lastname || 'N/A'}</p>
        <p><strong>Email:</strong> ${data.email || 'N/A'}</p>
        <p><strong>Broker:</strong> ${data.broker || 'N/A'}</p>
        <p><strong>Data Consent:</strong> ${data.data_consent ? 'Yes' : 'No'}</p>
        <p><strong>Marketing Consent:</strong> ${data.marketing_consent ? 'Yes' : 'No'}</p>
        <p><strong>Cookies Consent:</strong> ${data.cookies_consent ? 'Yes' : 'No'}</p>
        <p><strong>Affiliate:</strong> ${data.affiliate || 'N/A'}</p>
      </div>
    `;
    $('#thank-you').after(displayHtml);
  }

  function handleFormSubmission(event) {
    event.preventDefault();

    if (!areAllCheckboxesChecked()) {
      alert('You must agree to all terms and policies before submitting the form.');
      return;
    }

    const ajaxUrl = TL_AJAX.ajax_url;
    const nonce = TL_AJAX.nonce;
    const $form = $('form.tl-form');

    // Grab affiliate from form's action URL
    const url = new URL($form.attr('action') || window.location.href, window.location.href);
    const affiliate = url.searchParams.get('affiliate') || '';

    // Serialize form data and add affiliate, action, and nonce
    const payload = $form.serialize() +
                    '&affiliate=' + encodeURIComponent(affiliate) +
                    '&action=submit_signup' +
                    '&nonce=' + nonce;

    // AJAX request
    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: payload,
      dataType: 'json',
      success: function (res) {
        console.log('AJAX Response:', res);
        if (res.success) {
          // Log data to console
          console.log('Submitted Form Data:', res.data);

          // Save to cookie
          saveFormSubmissionToCookie();

          // Display data in HTML
          // displayFormData(res.data);

          // Show thank you message
          // $form.hide();
          // $('#thank-you').show();

          // Redirect after 1.5 seconds
          setTimeout(function () {
            window.location.href = affiliate || '/';
          }, 1500);
        } else {
          alert(res.data || 'Submission failed — please try again.');
        }
      },
      error: function (xhr) {
        const res = xhr.responseJSON || {};
        if (res.data && res.data.no_signup) {
          // Silent redirect for reCAPTCHA failures
          $('#signup-form').empty();
          $('#thank-you').html('<p>Redirecting in <span id="seconds">2</span> seconds...</p>');
          let seconds = 2;
          const countdown = setInterval(function () {
            seconds--;
            $('#seconds').text(seconds);
            if (seconds <= 0) {
              clearInterval(countdown);
            }
          }, 1000);
          setTimeout(function () {
            window.location.href = affiliate || '/';
          }, 2000);
        } else {
          alert(res.data?.message || 'Submission failed — please try again.');
        }
      }
    });
  }

  // Initialize popup and form submission
  showPopupOnAffiliateClick('#popup');
  $('form.tl-form').on('submit', handleFormSubmission);
});