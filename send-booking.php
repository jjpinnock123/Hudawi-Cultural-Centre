<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: booking.html");
    exit;
}

function clean_value($value) {
    if (is_array($value)) {
        $value = implode(", ", array_map('trim', $value));
    }
    $value = trim((string)$value);
    $value = str_replace(["", "
"], [" ", " "], $value);
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$formType = isset($_POST['form_type']) ? clean_value($_POST['form_type']) : 'booking';
$to = 'dominic@ngnf.co.uk, admin@hudawi.org.uk';
$siteEmail = 'no-reply@hudawi.org.uk';

if ($formType === 'contact') {
    $subject = 'New Contact Form Submission - HUDAWI Website';
} else {
    $subject = 'New Booking Enquiry - HUDAWI Website';
}

$labels = [
    'form_type' => 'Form Type',
    'full_name' => 'Full Name',
    'organisation' => 'Organisation',
    'address' => 'Address',
    'postcode' => 'Postcode',
    'email' => 'Email',
    'telephone' => 'Telephone',
    'phone' => 'Phone',
    'subject' => 'Subject',
    'message' => 'Message',
    'event_name' => 'Event Name / Description',
    'event_type' => 'Event Type',
    'event_date' => 'Date of Event',
    'start_time' => 'Start Time',
    'finish_time' => 'Finish Time',
    'setup_time' => 'Setup / Access Time Required',
    'attendees' => 'Expected Number of Attendees',
    'facilities' => 'Facilities Requested',
    'equipment' => 'Equipment Required',
    'equipment_other' => 'Other Equipment',
    'food_served' => 'Will food be served?',
    'kitchen_used' => 'Will the kitchen be used?',
    'external_caterer' => 'External caterer?',
    'caterer_name' => 'Caterer name',
    'alcohol_served' => 'Will alcohol be served?',
    'music_or_dj' => 'Amplified music / DJ / PA?',
    'children_attending' => 'Children or young people attending?',
    'large_equipment' => 'Decorations / staging / large equipment?',
    'attendance_over_150' => 'Attendance exceed 150 people?',
    'insurance_declaration' => 'Insurance declaration',
    'electrical_declaration' => 'Electrical equipment declaration',
    'accuracy_declaration' => 'Accuracy declaration',
    'applicant_name' => 'Applicant Name',
    'declaration_date' => 'Declaration Date'
];

$body = "HUDAWI Website Submission
";
$body .= "=========================

";

foreach ($_POST as $key => $value) {
    if ($key === 'submit') {
        continue;
    }
    $label = isset($labels[$key]) ? $labels[$key] : ucwords(str_replace('_', ' ', $key));
    $cleaned = is_array($value) ? implode(', ', array_map('clean_value', $value)) : clean_value($value);
    $body .= $label . ": " . $cleaned . "
";
}

$replyTo = !empty($_POST['email']) ? clean_value($_POST['email']) : $siteEmail;
$headers = [];
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/plain; charset=UTF-8';
$headers[] = 'From: HUDAWI Website <' . $siteEmail . '>';
$headers[] = 'Reply-To: ' . $replyTo;

$mailSent = mail($to, $subject, $body, implode("
", $headers));

if ($mailSent) {
    header('Location: thank-you.html?form=' . urlencode($formType));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Submission Error</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 min-h-screen flex items-center justify-center p-6">
  <div class="max-w-xl w-full bg-white rounded-2xl shadow-xl p-8 text-center">
    <h1 class="text-3xl font-bold mb-4">Sorry, your form could not be sent</h1>
    <p class="text-slate-600 mb-6">Please try again later or contact HUDAWI directly at info@hudawi.org.uk.</p>
    <a href="booking.html" class="inline-block rounded-full bg-amber-700 px-6 py-3 text-white font-semibold">Back to booking page</a>
  </div>
</body>
</html>
