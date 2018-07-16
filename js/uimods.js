(function ($) {
  $(document).on('crmLoad', function (event) {
    var context = event.target;

    // Adapt contact summary.
    var $contactSummary = $('#contact-summary', context);
    if ($contactSummary.length) {
      var $zusatzinformationenPatient = $('.customFieldGroup.Zusatzinformationen_Patient', context);
      var $zusatzinformationenKosten = $('.customFieldGroup.Zusatzinformationen_Patient_Kosten', context);
      var $zusatzinformationenBetreuungskraft = $('.customFieldGroup.Zusatzinformationen_Betreuungskraft', context);
      var $aktuelleBeziehungen = $('.crm-summary-block.Aktuelle_Beziehungen', context);
      var $communicationPreferences = $('#communication-pref-block', context);
      var $demographics = $('#demographic-block', context);
      var $addresses = $('#address-block-1', context).closest('.contact_panel').find('.address');
      var $emails = $('.crm-summary-email-block', context);
      var $phones = $('.crm-summary-phone-block', context);
      var $contactInfo = $('#contactinfo-block', context);
      var $contactInfo2 = $contactInfo.closest('.contactCardLeft').next('.contactCardRight').find('.crm-summary-block');

      $contactSummary
        .append(
          $('<div>')
            .addClass('contact_panel')
            .append($aktuelleBeziehungen)
            .append(
              $('<div>')
                .addClass('contactCardLeft')
                .append($zusatzinformationenPatient.addClass('crm-summary-block').css('margin-top', 0))
                .append($zusatzinformationenKosten.addClass('crm-summary-block').css('margin-top', 0))
                .append($zusatzinformationenBetreuungskraft.addClass('crm-summary-block').css('margin-top', 0))
                .append($communicationPreferences)
            )
            .append(
              $('<div>')
                .addClass('contactCardRight')
                .append($contactInfo2)
                .append($addresses.addClass('crm-summary-block'))
                .append($emails)
                .append($phones)
                .append($demographics)
                .append($contactInfo)
            )
        )
    }
  });
})(cj);
