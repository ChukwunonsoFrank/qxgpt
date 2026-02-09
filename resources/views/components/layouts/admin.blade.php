<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>
        Yfxai - Admin Dashboard
    </title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    <link href="{{ asset('assets/admin/style.css') }}" rel="stylesheet">
    @livewireStyles
</head>

<body x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }">
    <!-- ===== Preloader Start ===== -->
    <div x-show="loaded" x-init="window.addEventListener('DOMContentLoaded', () => { setTimeout(() => loaded = false, 500) })"
        class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black">
        <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent">
        </div>
    </div>

    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
        <!-- ===== Sidebar Start ===== -->
        <aside :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
            class="sidebar fixed top-0 left-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-auto border-r border-gray-200 bg-white px-5 transition-all duration-300 lg:static lg:translate-x-0 dark:border-gray-800 dark:bg-black"
            @click.outside="sidebarToggle = false">

            <div class="no-scrollbar flex flex-col pt-8 overflow-y-auto duration-300 ease-linear">
                <!-- Sidebar Menu -->
                <nav x-data="{ selected: $persist('Dashboard') }">
                    <!-- Menu Group -->
                    <div class="pt-16">
                        <ul class="mb-6 flex flex-col gap-4">
                            <!-- Menu Item Dashboard -->
                            <li>
                                <a href="{{ route('admin.dashboard') }}"
                                    @click="selected = (selected === 'Dashboard' ? '':'Dashboard')"
                                    class="menu-item group"
                                    :class="(selected === 'Dashboard') && (page === 'dashboard') ? 'menu-item-active' :
                                    'menu-item-inactive'">
                                    <svg class="menu-item-icon-inactive" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V8.99998C3.25 10.2426 4.25736 11.25 5.5 11.25H9C10.2426 11.25 11.25 10.2426 11.25 8.99998V5.5C11.25 4.25736 10.2426 3.25 9 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H9C9.41421 4.75 9.75 5.08579 9.75 5.5V8.99998C9.75 9.41419 9.41421 9.74998 9 9.74998H5.5C5.08579 9.74998 4.75 9.41419 4.75 8.99998V5.5ZM5.5 12.75C4.25736 12.75 3.25 13.7574 3.25 15V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H9C10.2426 20.75 11.25 19.7427 11.25 18.5V15C11.25 13.7574 10.2426 12.75 9 12.75H5.5ZM4.75 15C4.75 14.5858 5.08579 14.25 5.5 14.25H9C9.41421 14.25 9.75 14.5858 9.75 15V18.5C9.75 18.9142 9.41421 19.25 9 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V15ZM12.75 5.5C12.75 4.25736 13.7574 3.25 15 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V8.99998C20.75 10.2426 19.7426 11.25 18.5 11.25H15C13.7574 11.25 12.75 10.2426 12.75 8.99998V5.5ZM15 4.75C14.5858 4.75 14.25 5.08579 14.25 5.5V8.99998C14.25 9.41419 14.5858 9.74998 15 9.74998H18.5C18.9142 9.74998 19.25 9.41419 19.25 8.99998V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H15ZM15 12.75C13.7574 12.75 12.75 13.7574 12.75 15V18.5C12.75 19.7426 13.7574 20.75 15 20.75H18.5C19.7426 20.75 20.75 19.7427 20.75 18.5V15C20.75 13.7574 19.7426 12.75 18.5 12.75H15ZM14.25 15C14.25 14.5858 14.5858 14.25 15 14.25H18.5C18.9142 14.25 19.25 14.5858 19.25 15V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15C14.5858 19.25 14.25 18.9142 14.25 18.5V15Z"
                                            fill="" />
                                    </svg>

                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                        Dashboard
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item Dashboard -->

                            <!-- Menu Item Users -->
                            <li>
                                <a href="{{ route('admin.dashboard.users') }}"
                                    @click="selected = (selected === 'Users' ? '':'Users')" class="menu-item group"
                                    :class="(selected === 'Users') && (page === 'users') ? 'menu-item-active' :
                                    'menu-item-inactive'">
                                    <svg :class="(selected === 'Users') && (page === 'users') ? 'menu-item-icon-active' :
                                    'menu-item-icon-inactive'"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M12 3.5C7.30558 3.5 3.5 7.30558 3.5 12C3.5 14.1526 4.3002 16.1184 5.61936 17.616C6.17279 15.3096 8.24852 13.5955 10.7246 13.5955H13.2746C15.7509 13.5955 17.8268 15.31 18.38 17.6167C19.6996 16.119 20.5 14.153 20.5 12C20.5 7.30558 16.6944 3.5 12 3.5ZM17.0246 18.8566V18.8455C17.0246 16.7744 15.3457 15.0955 13.2746 15.0955H10.7246C8.65354 15.0955 6.97461 16.7744 6.97461 18.8455V18.856C8.38223 19.8895 10.1198 20.5 12 20.5C13.8798 20.5 15.6171 19.8898 17.0246 18.8566ZM2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9991 7.25C10.8847 7.25 9.98126 8.15342 9.98126 9.26784C9.98126 10.3823 10.8847 11.2857 11.9991 11.2857C13.1135 11.2857 14.0169 10.3823 14.0169 9.26784C14.0169 8.15342 13.1135 7.25 11.9991 7.25ZM8.48126 9.26784C8.48126 7.32499 10.0563 5.75 11.9991 5.75C13.9419 5.75 15.5169 7.32499 15.5169 9.26784C15.5169 11.2107 13.9419 12.7857 11.9991 12.7857C10.0563 12.7857 8.48126 11.2107 8.48126 9.26784Z"
                                            fill="" />
                                    </svg>

                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                        Users
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item Users -->

                            <!-- Menu Item Email Broadcast -->
                            <li>
                                <a href="{{ route('admin.dashboard.broadcast') }}"
                                    @click="selected = (selected === 'Email Broadcast' ? '':'Email Broadcast')"
                                    class="menu-item group"
                                    :class="(selected === 'Email Broadcast') && (page === 'email-broadcast') ?
                                    'menu-item-active' :
                                    'menu-item-inactive'">
                                    <svg class="menu-item-icon-inactive" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.5 8.187V17.25C3.5 17.6642 3.83579 18 4.25 18H19.75C20.1642 18 20.5 17.6642 20.5 17.25V8.18747L13.2873 13.2171C12.5141 13.7563 11.4866 13.7563 10.7134 13.2171L3.5 8.187ZM20.5 6.2286C20.5 6.23039 20.5 6.23218 20.5 6.23398V6.24336C20.4976 6.31753 20.4604 6.38643 20.3992 6.42905L12.4293 11.9867C12.1716 12.1664 11.8291 12.1664 11.5713 11.9867L3.60116 6.42885C3.538 6.38481 3.50035 6.31268 3.50032 6.23568C3.50028 6.10553 3.60577 6 3.73592 6H20.2644C20.3922 6 20.4963 6.10171 20.5 6.2286ZM22 6.25648V17.25C22 18.4926 20.9926 19.5 19.75 19.5H4.25C3.00736 19.5 2 18.4926 2 17.25V6.23398C2 6.22371 2.00021 6.2135 2.00061 6.20333C2.01781 5.25971 2.78812 4.5 3.73592 4.5H20.2644C21.2229 4.5 22 5.27697 22.0001 6.23549C22.0001 6.24249 22.0001 6.24949 22 6.25648Z"
                                            fill="" />
                                    </svg>

                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                        Email Broadcast
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item Email Broadcast -->

                            <!-- Menu Item Strategy -->
                            <li>
                                <a href="{{ route('admin.dashboard.strategy') }}"
                                    @click="selected = (selected === 'Strategy' ? '':'Strategy')"
                                    class="menu-item group"
                                    :class="(selected === 'Strategy') && (page === 'strategy') ? 'menu-item-active' :
                                    'menu-item-inactive'">
                                    <svg class="menu-item-icon-inactive" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M19.5 19.75C19.5 20.9926 18.4926 22 17.25 22H6.75C5.50736 22 4.5 20.9926 4.5 19.75V9.62105C4.5 9.02455 4.73686 8.45247 5.15851 8.03055L10.5262 2.65951C10.9482 2.23725 11.5207 2 12.1177 2H17.25C18.4926 2 19.5 3.00736 19.5 4.25V19.75ZM17.25 20.5C17.6642 20.5 18 20.1642 18 19.75V4.25C18 3.83579 17.6642 3.5 17.25 3.5H12.248L12.2509 7.49913C12.2518 8.7424 11.2442 9.75073 10.0009 9.75073H6V19.75C6 20.1642 6.33579 20.5 6.75 20.5H17.25ZM7.05913 8.25073L10.7488 4.55876L10.7509 7.5002C10.7512 7.91462 10.4153 8.25073 10.0009 8.25073H7.05913ZM8.25 14.5C8.25 14.0858 8.58579 13.75 9 13.75H15C15.4142 13.75 15.75 14.0858 15.75 14.5C15.75 14.9142 15.4142 15.25 15 15.25H9C8.58579 15.25 8.25 14.9142 8.25 14.5ZM8.25 17.5C8.25 17.0858 8.58579 16.75 9 16.75H12C12.4142 16.75 12.75 17.0858 12.75 17.5C12.75 17.9142 12.4142 18.25 12 18.25H9C8.58579 18.25 8.25 17.9142 8.25 17.5Z"
                                            fill="" />
                                    </svg>

                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                        Strategies
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item Strategy -->

                            <!-- Menu Item Deposits -->
                            <li>
                                <a href="{{ route('admin.dashboard.depositintents') }}"
                                    @click="selected = (selected === 'DepositIntents' ? '':'DepositIntents')"
                                    class="menu-item group"
                                    :class="(selected === 'DepositIntents') && (page === 'deposit-intents') ?
                                    'menu-item-active' :
                                    'menu-item-inactive'">
                                    <svg class="menu-item-icon-inactive" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H18.5001C19.7427 20.75 20.7501 19.7426 20.7501 18.5V5.5C20.7501 4.25736 19.7427 3.25 18.5001 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H18.5001C18.9143 4.75 19.2501 5.08579 19.2501 5.5V18.5C19.2501 18.9142 18.9143 19.25 18.5001 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V5.5ZM6.25005 9.7143C6.25005 9.30008 6.58583 8.9643 7.00005 8.9643L17 8.96429C17.4143 8.96429 17.75 9.30008 17.75 9.71429C17.75 10.1285 17.4143 10.4643 17 10.4643L7.00005 10.4643C6.58583 10.4643 6.25005 10.1285 6.25005 9.7143ZM6.25005 14.2857C6.25005 13.8715 6.58583 13.5357 7.00005 13.5357H17C17.4143 13.5357 17.75 13.8715 17.75 14.2857C17.75 14.6999 17.4143 15.0357 17 15.0357H7.00005C6.58583 15.0357 6.25005 14.6999 6.25005 14.2857Z"
                                            fill="" />
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                        Deposit Intents
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item Deposits -->

                            <!-- Menu Item Deposits -->
                            <li>
                                <a href="{{ route('admin.dashboard.deposits') }}"
                                    @click="selected = (selected === 'Deposits' ? '':'Deposits')"
                                    class="menu-item group"
                                    :class="(selected === 'Deposits') && (page === 'deposits') ? 'menu-item-active' :
                                    'menu-item-inactive'">
                                    <svg class="menu-item-icon-inactive" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H18.5001C19.7427 20.75 20.7501 19.7426 20.7501 18.5V5.5C20.7501 4.25736 19.7427 3.25 18.5001 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H18.5001C18.9143 4.75 19.2501 5.08579 19.2501 5.5V18.5C19.2501 18.9142 18.9143 19.25 18.5001 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V5.5ZM6.25005 9.7143C6.25005 9.30008 6.58583 8.9643 7.00005 8.9643L17 8.96429C17.4143 8.96429 17.75 9.30008 17.75 9.71429C17.75 10.1285 17.4143 10.4643 17 10.4643L7.00005 10.4643C6.58583 10.4643 6.25005 10.1285 6.25005 9.7143ZM6.25005 14.2857C6.25005 13.8715 6.58583 13.5357 7.00005 13.5357H17C17.4143 13.5357 17.75 13.8715 17.75 14.2857C17.75 14.6999 17.4143 15.0357 17 15.0357H7.00005C6.58583 15.0357 6.25005 14.6999 6.25005 14.2857Z"
                                            fill="" />
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                        Deposits
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item Deposits -->

                            <!-- Menu Item Withdrawals -->
                            <li>
                                <a href="{{ route('admin.dashboard.withdrawals') }}"
                                    @click="selected = (selected === 'Withdrawals' ? '':'Withdrawals')"
                                    class="menu-item group"
                                    :class="(selected === 'Withdrawals') && (page === 'withdrawals') ? 'menu-item-active' :
                                    'menu-item-inactive'">
                                    <svg class="menu-item-icon-inactive" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H18.5001C19.7427 20.75 20.7501 19.7426 20.7501 18.5V5.5C20.7501 4.25736 19.7427 3.25 18.5001 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H18.5001C18.9143 4.75 19.2501 5.08579 19.2501 5.5V18.5C19.2501 18.9142 18.9143 19.25 18.5001 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V5.5ZM6.25005 9.7143C6.25005 9.30008 6.58583 8.9643 7.00005 8.9643L17 8.96429C17.4143 8.96429 17.75 9.30008 17.75 9.71429C17.75 10.1285 17.4143 10.4643 17 10.4643L7.00005 10.4643C6.58583 10.4643 6.25005 10.1285 6.25005 9.7143ZM6.25005 14.2857C6.25005 13.8715 6.58583 13.5357 7.00005 13.5357H17C17.4143 13.5357 17.75 13.8715 17.75 14.2857C17.75 14.6999 17.4143 15.0357 17 15.0357H7.00005C6.58583 15.0357 6.25005 14.6999 6.25005 14.2857Z"
                                            fill="" />
                                    </svg>

                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                        Withdrawals
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item Withdrawals -->

                            <!-- Menu Item Payment Methods -->
                            <li>
                                <a href="{{ route('admin.dashboard.paymentmethods') }}"
                                    @click="selected = (selected === 'Payment Methods' ? '':'Payment Methods')"
                                    class="menu-item group"
                                    :class="(selected === 'Payment Methods') && (page === 'payment-methods') ?
                                    'menu-item-active' :
                                    'menu-item-inactive'">
                                    <svg class="menu-item-icon-inactive" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.665 3.75618C11.8762 3.65061 12.1247 3.65061 12.3358 3.75618L18.7807 6.97853L12.3358 10.2009C12.1247 10.3064 11.8762 10.3064 11.665 10.2009L5.22014 6.97853L11.665 3.75618ZM4.29297 8.19199V16.0946C4.29297 16.3787 4.45347 16.6384 4.70757 16.7654L11.25 20.0365V11.6512C11.1631 11.6205 11.0777 11.5843 10.9942 11.5425L4.29297 8.19199ZM12.75 20.037L19.2933 16.7654C19.5474 16.6384 19.7079 16.3787 19.7079 16.0946V8.19199L13.0066 11.5425C12.9229 11.5844 12.8372 11.6207 12.75 11.6515V20.037ZM13.0066 2.41453C12.3732 2.09783 11.6277 2.09783 10.9942 2.41453L4.03676 5.89316C3.27449 6.27429 2.79297 7.05339 2.79297 7.90563V16.0946C2.79297 16.9468 3.27448 17.7259 4.03676 18.1071L10.9942 21.5857L11.3296 20.9149L10.9942 21.5857C11.6277 21.9024 12.3732 21.9024 13.0066 21.5857L19.9641 18.1071C20.7264 17.7259 21.2079 16.9468 21.2079 16.0946V7.90563C21.2079 7.05339 20.7264 6.27429 19.9641 5.89316L13.0066 2.41453Z"
                                            fill="" />
                                    </svg>

                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                        Payment Methods
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item Payment Methods -->

                            <!-- Menu Item Payment Methods -->
                            <li>
                                <a href="{{ route('admin.dashboard.kyc') }}"
                                    @click="selected = (selected === 'KYC' ? '':'KYC')" class="menu-item group"
                                    :class="(selected === 'KYC') && (page === 'kyc') ?
                                    'menu-item-active' :
                                    'menu-item-inactive'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="#344054" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-id-card-icon lucide-id-card">
                                        <path d="M16 10h2" />
                                        <path d="M16 14h2" />
                                        <path d="M6.17 15a3 3 0 0 1 5.66 0" />
                                        <circle cx="9" cy="11" r="2" />
                                        <rect x="2" y="5" width="20" height="14" rx="2" />
                                    </svg>

                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                        KYC
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item Payment Methods -->
                        </ul>
                    </div>
                </nav>
                <!-- Sidebar Menu -->
            </div>
        </aside>
        <!-- ===== Sidebar End ===== -->

        {{ $slot }}

    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @livewireScripts
    {{-- @vite('resources/js/app.js') --}}
</body>

</html>
