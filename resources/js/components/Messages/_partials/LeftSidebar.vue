<script setup>
    import { useChatStore } from "@/stores/ChatStore";

    const { authUser } = useChatStore();
</script>

<template>
    <div class="col app-chat-sidebar-left app-sidebar overflow-hidden" id="app-chat-sidebar-left">
        <div class="chat-sidebar-left-user sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap p-4 mt-2">
            <div class="avatar avatar-xl avatar-online">
                <img :src="authUser.avatar ? authUser.avatar : '/assets/img/avatars/1.png'" alt="Avatar" class="rounded-circle" />
            </div>
            <h5 class="mt-3 mb-1">{{ authUser.first_name + " " + authUser.last_name }}</h5>
            <small class="text-muted">{{ authUser.role }}</small>
            <i class="bx bx-x bx-sm cursor-pointer close-sidebar" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-left"></i>
        </div>

        <div class="sidebar-body px-4 pb-4">
            <div class="my-3">
                <span class="text-muted text-uppercase">About</span>
                <textarea id="chat-sidebar-left-user-about" class="form-control chat-sidebar-left-user-about mt-2" rows="4" maxlength="120">
                    Dessert chocolate cake lemon drops jujubes. Biscuit cupcake ice cream bear claw brownie brownie marshmallow.
                </textarea>
            </div>
            <div class="my-4">
                <span class="text-muted text-uppercase">Status</span>
                <div class="d-grid gap-1 mt-2">
                    <div class="form-check form-check-success">
                        <input name="chat-user-status" class="form-check-input" type="radio" value="active" id="user-active" checked />
                        <label class="form-check-label" for="user-active">Active</label>
                    </div>
                    <div class="form-check form-check-danger">
                        <input name="chat-user-status" class="form-check-input" type="radio" value="busy" id="user-busy" />
                        <label class="form-check-label" for="user-busy">Busy</label>
                    </div>
                    <div class="form-check form-check-warning">
                        <input name="chat-user-status" class="form-check-input" type="radio" value="away" id="user-away" />
                        <label class="form-check-label" for="user-away">Away</label>
                    </div>
                    <div class="form-check form-check-secondary">
                        <input name="chat-user-status" class="form-check-input" type="radio" value="offline" id="user-offline" />
                        <label class="form-check-label" for="user-offline">Offline</label>
                    </div>
                </div>
            </div>
            <div class="my-4">
                <span class="text-muted text-uppercase">Settings</span>
                <ul class="list-unstyled d-grid gap-2 mt-2">
                    <li class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bx bx-check-circle me-1"></i>
                            <span class="align-middle">Two-step Verification</span>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="twoStepVerification" />
                        </div>
                    </li>
                    <li class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bx bx-bell me-1"></i>
                            <span class="align-middle">Notification</span>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="switchNotification" checked />
                        </div>
                    </li>
                    <li>
                        <i class="bx bx-user me-1"></i>
                        <span class="align-middle">Invite Friends</span>
                    </li>
                    <li>
                        <i class="bx bx-trash-alt me-1"></i>
                        <span class="align-middle">Delete Account</span>
                    </li>
                </ul>
            </div>
            <div class="d-flex mt-4">
                <button class="btn btn-primary" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-left">
                    Logout
                </button>
            </div>
        </div>
    </div>
</template>
