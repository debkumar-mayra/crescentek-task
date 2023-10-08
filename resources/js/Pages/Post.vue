<template>
    <v-card>
        <v-layout>
            <v-navigation-drawer class="bg-deep-purple" theme="dark" permanent>
                <v-list color="transparent">
                    <Link :href="route('profile')"
                        ><v-list-item
                            prepend-icon="mdi-view-dashboard"
                            title="Profile"
                        ></v-list-item
                    ></Link>
                    <Link :href="route('posts')"
                        ><v-list-item
                            prepend-icon="mdi-view-dashboard"
                            title="Posts"
                        ></v-list-item
                    ></Link>
                    <!-- <v-list-item prepend-icon="mdi-account-box" title="Account"></v-list-item>
          <v-list-item prepend-icon="mdi-gavel" title="Admin"></v-list-item> -->
                </v-list>

                <template v-slot:append>
                    <div class="pa-2">
                        <Link :href="route('logout')" method="post" as="button">
                            <v-btn block> Logout </v-btn></Link
                        >
                    </div>
                </template>
            </v-navigation-drawer>
            <v-main class="min-h-screen">
                <v-card>
                    <v-card-text>
                        <v-btn color="primary" @click="dialog = true">
                            + Add New
                        </v-btn>

                        <v-row justify="center">
                            <v-dialog v-model="dialog" persistent width="1024">
                                <v-form @submit.prevent="submit">
                                    <v-card>
                                        <v-card-title>
                                            <span class="text-h5">Post</span>
                                        </v-card-title>
                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col
                                                        cols="12"
                                                        sm="6"
                                                        md="12"
                                                    >
                                                        <v-text-field
                                                            label="Title"
                                                            variant="outlined"
                                                            v-model="
                                                                form.post_title
                                                            "
                                                            :error-messages="
                                                                errors.post_title
                                                            "
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row>
                                                    <v-col
                                                        cols="12"
                                                        sm="6"
                                                        md="12"
                                                    >
                                                        <v-textarea
                                                            label="Description"
                                                            variant="outlined"
                                                            v-model="
                                                                form.description
                                                            "
                                                            :error-messages="
                                                                errors.description
                                                            "
                                                        ></v-textarea>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                color="blue-darken-1"
                                                variant="text"
                                                @click="dialog = false"
                                            >
                                                Close
                                            </v-btn>
                                            <v-btn
                                                color="primary"
                                                variant="flat"
                                                type="submit"
                                                :loading="form.processing"
                                                :disabled="form.processing"
                                            >
                                                Save
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-form>
                            </v-dialog>
                        </v-row>

                        <v-card class="mt-10">
                            <v-table>
                                <thead>
                                    <tr>
                                        <th class="text-left">Title</th>
                                        <th class="text-left">Description</th>
                                        <th class="text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="post in posts" :key="post.id">
                                        <td>{{ post.post_title }}</td>
                                        <td>{{ post.description }}</td>
                                        <td>
                                            <div class="flex items-center">
                                                <Link
                                                    :href="
                                                        route('editPost', [
                                                            $page.props.auth
                                                                .user.id,
                                                            post.id,
                                                        ])
                                                    "
                                                    class="text-orange-400 ml-2"
                                                >
                                                    <Icon
                                                        icon="uil:edit"
                                                        width="24"
                                                        height="24"
                                                    />
                                                </Link>

                                                <a
                                                    href="javascript:void(0)"
                                                    class="text-red-600 ml-2"
                                                    @click="deletePost(post.id)"
                                                >
                                                    <Icon
                                                        icon="typcn:delete-outline"
                                                        width="32"
                                                        height="32"
                                                    />
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </v-table>
                        </v-card>
                    </v-card-text>
                </v-card>
            </v-main>
        </v-layout>
    </v-card>
</template>

<script setup>
import { router, useForm, usePage } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import { createToaster } from "@meforma/vue-toaster";

const toaster = createToaster({
    /* options */
});

const dialog = ref(false);

const {
    post = null,
    posts,
    errors,
} = defineProps({ post: Object, posts: Object, errors: Object });

const form = useForm({
    post_title: null,
    description: null,
});

const submit = () => {
    if (post != null) {
        form.post(route("updatePost", post.id), {
            onSuccess: () => {
                dialog.value = false;
                form.reset("post_title", "description");
                if (usePage().props.flash.success) {
                    toaster.success(usePage().props.flash.success, {
                        position: "top-right",
                    });
                }

                if (usePage().props.flash.error) {
                    toaster.error(usePage().props.flash.error, {
                        position: "top-right",
                    });
                }
            },
        });
    } else {
        form.post(route("addPost"), {
            onSuccess: () => {
                dialog.value = false;
                form.reset("post_title", "description");
                if (usePage().props.flash.success) {
                    toaster.success(usePage().props.flash.success, {
                        position: "top-right",
                    });
                }

                if (usePage().props.flash.error) {
                    toaster.error(usePage().props.flash.error, {
                        position: "top-right",
                    });
                }
            },
        });
    }
};

const deletePost = (id) => {
    router.delete(route("deletePost", [usePage().props.auth.user.id, id]), {
        preserveScroll: true,
        onBefore: (visit) => {
            if (!confirm("Are you sure want delete it")) {
                return false;
            }
        },
        onSuccess: () => {
            if (usePage().props.flash.success) {
                toaster.success(usePage().props.flash.success, {
                    position: "top-right",
                });
            }

            if (usePage().props.flash.error) {
                toaster.error(usePage().props.flash.error, {
                    position: "top-right",
                });
            }
        },
    });
};

onMounted(() => {
    if (post != null) {
        form.post_title = post.post_title;
        form.description = post.description;
        dialog.value = true;
    }
});
</script>
