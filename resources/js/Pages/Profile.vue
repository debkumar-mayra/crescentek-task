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
                <div class="h-screen flex justify-center items-center">
                    <v-card class="mx-auto" width="500">
                        <v-card-text>
                            <div>Welcome</div>
                            <p class="text-h4 text--primary">
                                {{ $page.props.auth.user.name }}
                            </p>
                            <p>Name: {{ $page.props.auth.user.name }}</p>
                            <div class="text--primary">
                                Email:{{ $page.props.auth.user.email }}<br />
                                Phone:{{ $page.props.auth.user.phone }}
                            </div>
                        </v-card-text>
                    </v-card>
                </div>
            </v-main>
        </v-layout>
    </v-card>
</template>
