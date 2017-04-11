<template>
    <ul id="{{menu.subMenuId}}" class="dropdown-content" v-for="menu in config.menus">
        <li v-for="sub in menu.subMenus">
            <a :href="sub.url" >{{ sub.name }}</a>
        </li>
    </ul>
    <ul id="dropdown-logout" class="dropdown-content">
       <li>
            <a :href="{{config.urlLogout}}" @click.prevent="submitLogout()">
                Logout
            </a>
            <form id="logout-form" :action="config.urlLogout" method="POST" style="display: none;">
                <input type="hidden" name="_token" :value="config.csrfToken">
            </form>
        </li>
    </ul>
    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper">
                <div class="row">
                    <div class="col s12">
                        <a :href="#" class="brand-logo left">TMO Financeiro</a>
                        <a :href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                        <ul id="nav-mobile" class="hide-on-med-and-down right">
                            <li v-for="m in config.menus">
                                <a :href="#!" v-if="m.subMenuId" class="dropdown-button" data-activates="{{m.subMenuId}}">
                                    {{ m.name }} <i class="material-icons right">arrow_drop_down</i>
                                </a>
                                <a :href="m.url" v-if="!m.subMenuId" >
                                    {{ m.name }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-button" data-activates="dropdown-logout">
                                    {{ config.name }} <i class="material-icons right">arrow_drop_down</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>

<script type="text/javascript">
    export default {
        props: {
            config: {
                type: Object,
                default () {
                    return {
                        name: '',
                        menus: [],
                        urlLogout: '/admin/logout'
                    }
                }
            }
        },
        ready() {
            $(".button-collapse").sideNav()
            $(".dropdown-button").dropdown()
        },
        methods: {
            submitLogout() {
                $('#logout-form').submit();
            }
        }
    }
</script>