@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<div class="container mx-auto py-12 px-4 max-w-3xl">
    <h1 class="text-3xl font-bold mb-6">Privacy Policy</h1>
    <div class="prose prose-lg">
        <p>Your privacy is important to us. This Privacy Policy explains how CashBook collects, uses, and protects your information.</p>
        <h2>Information We Collect</h2>
        <ul>
            <li>Account information (name, email, etc.)</li>
            <li>Business and financial data you provide</li>
            <li>Usage and device information</li>
        </ul>
        <h2>How We Use Information</h2>
        <ul>
            <li>To provide and improve our services</li>
            <li>To communicate with you about your account</li>
            <li>To ensure security and prevent fraud</li>
        </ul>
        <h2>Data Security</h2>
        <p>We use industry-standard security measures to protect your data. Your information is never sold or shared with third parties except as required by law.</p>
        <h2>Your Rights</h2>
        <ul>
            <li>You can access, update, or delete your information at any time.</li>
            <li>Contact us for any privacy-related questions.</li>
        </ul>
        <h2>Contact</h2>
        <p>If you have questions about this policy, contact us at <a href="mailto:support@cashbook.com">support@cashbook.com</a>.</p>
        <p class="mt-8 text-sm text-gray-500">Last updated: {{ date('F j, Y') }}</p>
    </div>
</div>
@endsection
