<script setup>
    import LeftSidebar from '@/components/Messages/_partials/LeftSidebar';
    import ContactList from '@/components/Messages/_partials/ContactList';
    import ChatHistory from '@/components/Messages/_partials/ChatHistory';
    import { useChatStore } from "@/stores/ChatStore";

    const props = defineProps({
        user: {
            default: null,
        }
    });

    const store = useChatStore();
    store.authUser = JSON.parse(props.user);
</script>

<template>
    <div class="app-chat overflow-hidden card">
        <div class="row g-0">
            <!-- Sidebar Left -->
            <LeftSidebar />
            <!-- /Sidebar Left-->

            <!-- Chat & Contacts -->
            <ContactList />
            <!-- /Chat contacts -->

            <!-- Chat History -->
            <ChatHistory />
            <!-- /Chat History -->

            <!-- Sidebar Right -->
            <div class="col app-chat-sidebar-right app-sidebar overflow-hidden" id="app-chat-sidebar-right">
                <div class="sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap p-4 mt-2">
                    <div class="avatar avatar-xl avatar-online">
                        <span class="avatar-initial rounded-circle bg-label-success">A-1</span>
                    </div>
                    <h6 class="mt-3 mb-1">Felecia Rower</h6>
                    <small class="text-muted">NextJS Developer</small>
                    <i class="bx bx-x bx-sm cursor-pointer close-sidebar d-block" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-right"></i>
                </div>
                <div class="sidebar-body px-4 pb-4">
                    <div class="my-3">
                        <span class="text-muted text-uppercase">About</span>
                        <p class="mb-0 mt-2">
                            A Next. js developer is a software developer who uses the Next. js framework alongside ReactJS to build web applications.
                        </p>
                    </div>
                    <div class="my-4">
                        <span class="text-muted text-uppercase">Personal Information</span>
                        <ul class="list-unstyled d-grid gap-2 mt-2">
                            <li class="d-flex align-items-center">
                                <i class="bx bx-envelope"></i>
                                <span class="align-middle ms-2">josephGreen@email.com</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="bx bx-phone-call"></i>
                                <span class="align-middle ms-2">+1(123) 456 - 7890</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="bx bx-time-five"></i>
                                <span class="align-middle ms-2">Mon - Fri 10AM - 8PM</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-4">
                        <span class="text-muted text-uppercase">Options</span>
                        <ul class="list-unstyled d-grid gap-2 mt-2">
                            <li class="cursor-pointer d-flex align-items-center">
                                <i class="bx bx-bookmark"></i>
                                <span class="align-middle ms-2">Add Tag</span>
                            </li>
                            <li class="cursor-pointer d-flex align-items-center">
                                <i class="bx bx-star"></i>
                                <span class="align-middle ms-2">Important Contact</span>
                            </li>
                            <li class="cursor-pointer d-flex align-items-center">
                                <i class="bx bx-image-alt"></i>
                                <span class="align-middle ms-2">Shared Media</span>
                            </li>
                            <li class="cursor-pointer d-flex align-items-center">
                                <i class="bx bx-trash-alt"></i>
                                <span class="align-middle ms-2">Delete Contact</span>
                            </li>
                            <li class="cursor-pointer d-flex align-items-center">
                                <i class="bx bx-block"></i>
                                <span class="align-middle ms-2">Block Contact</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Sidebar Right -->

            <div class="app-overlay"></div>
        </div>
    </div>
</template>