<template>
    <div v-if="user">
        <div class="field">
            <label class="label">{{ $t('user_setting.info.user_name') }}</label>
            <div class="control has-icons-left has-icons-right">
                <input
                    class="input is-success"
                    type="text"
                    name="user_name"
                    v-model="userName"
                />
                <span class="icon is-small is-left">
                    <i class="fa-solid fa-user"></i>
                </span>
            </div>
        </div>
        <div class="field">
            <label class="label">{{ $t('user_setting.info.ask_live') }}</label>
            <div class="control has-icons-left has-icons-right">
                <input
                    class="input is-success"
                    type="text"
                    name="living_place"
                    v-model="livingPlace"
                />
                <span class="icon is-small is-left">
                    <i class="fa-solid fa-house"></i>
                </span>
            </div>
        </div>
        <div class="field">
            <label class="label">{{ $t('user_setting.info.ask_work') }}</label>
            <div class="control has-icons-left has-icons-right">
                <input
                    class="input is-success"
                    type="text"
                    name="working_place"
                    v-model="workingPlace"
                />
                <span class="icon is-small is-left">
                    <i class="fa-solid fa-house"></i>
                </span>
            </div>
        </div>
        <label class="label">{{ $t('user_setting.info.highschool') }}</label>
        <div v-for="(highschool, index) in highSchool" class="columns">
            <div class="field column">
                <label class="label">{{ $t('user_setting.info.school_name') }}</label>
                <div class="control has-icons-left has-icons-right">
                    <input
                        class="input is-success"
                        type="text"
                        name="highschool_name"
                        v-model="highschool.school_name"
                    />
                    <span class="icon is-small is-left">
                        <i class="fa-solid fa-school"></i>
                    </span>
                </div>
            </div>
            <div class="field column">
                <label class="label">{{ $t('user_setting.info.start_year') }}:</label>
                <div class="control">
                    <div class="select">
                        <select
                            class="year-select"
                            name="highschool_start"
                            v-model="highschool.start_year"
                        >
                            <option v-for="year in years">{{ year }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field column">
                <label class="label">{{ $t('user_setting.info.end_year') }}:</label>
                <div class="control">
                    <div class="select">
                        <select
                            class="year-select"
                            name="highschool_start"
                            v-model="highschool.end_year"
                        >
                            <option v-for="year in years">{{ year }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field column btn-delete-school">
                <button
                    @click="deleteHighSchool(index)"
                    class="button is-danger is-outlined"
                >
                    <span>{{ $t('delete') }}</span>
                    <span class="icon is-small">
                        <i class="fas fa-times"></i>
                    </span>
                </button>
            </div>
        </div>
        <div>
            <button
                @click="addHighSchoolInput"
                class="button btn-add-school is-link is-light"
            >
                <span>{{ $t('user_setting.info.highschool_addmore') }}</span>
                &nbsp;
                <span><i class="fa-solid fa-circle-plus"></i></span>
            </button>
        </div>
        <label class="label">{{ $t('user_setting.info.university') }}</label>
        <div v-for="university in university" class="columns">
            <div class="field column">
                <label class="label">{{ $t('user_setting.info.university_name') }}</label>
                <div class="control has-icons-left has-icons-right">
                    <input
                        class="input is-success"
                        name="university_name"
                        type="text"
                        v-model="university.school_name"
                    />
                    <span class="icon is-small is-left">
                        <i class="fa-solid fa-school"></i>
                    </span>
                </div>
            </div>
            <div class="field column">
                <label class="label">{{ $t('user_setting.info.start_year') }}</label>
                <div class="control">
                    <div class="select">
                        <select
                            class="year-select"
                            name="university_start"
                            v-model="university.start_year"
                        >
                            <option v-for="year in years">{{ year }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field column">
                <label class="label">{{ $t('user_setting.info.graduated_year') }}</label>
                <div class="control">
                    <div class="select">
                        <select
                            class="year-select"
                            name="university_gradueted"
                            v-model="university.end_year"
                        >
                            <option v-for="year in years">{{ year }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field column btn-delete-school">
                <button
                    @click="deleteUniversity(index)"
                    class="button is-danger is-outlined"
                >
                    <span>{{ $t('delete') }}</span>
                    <span class="icon is-small">
                        <i class="fas fa-times"></i>
                    </span>
                </button>
            </div>
        </div>
        <div>
            <button
                @click="addUniversityInput"
                class="button btn-add-school is-link is-light"
            >
                <span>{{ $t('user_setting.info.university_addmore') }}</span>
                &nbsp;
                <span><i class="fa-solid fa-circle-plus"></i></span>
            </button>
        </div>
        <div class="field">
            <label class="label">{{ $t('user_setting.info.iam') }}</label>
            <div class="control">
                <div class="select">
                    <select name="gender" v-model="gender">
                        <option value="male">{{ $t('user_setting.info.male') }}</option>
                        <option value="female">{{ $t('user_setting.info.female') }}</option>
                        <option value="other">{{ $t('user_setting.info.other') }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="field is-grouped mt-3 columns is-justify-content-end">
            <button
                @click="saveInformation"
                class="button is-info is-1-desktop is-full-mobile"
            >
                {{ $t('save') }}
            </button>
        </div>
    </div>
    <div v-else>
        <LoadingComponent />
    </div>
</template>

<script>
import { updateUserProfile, getProfile } from "../../api/user";
import LoadingComponent from "../Common/LoadingComponent.vue";
import { useToast } from "vue-toastification";

export default {
    components: { LoadingComponent },
    data() {
        return {
            years: [],
            livingPlace: null,
            workingPlace: null,
            highSchool: [],
            university: [],
            gender: null,
            userName: null,
            user: null,
        };
    },
    watch: {
        user(data) {
            this.livingPlace = data?.user_information.living_place;
            this.workingPlace = data?.user_information.working_place;
            this.highSchool =
                data?.user_school?.flatMap((r) =>
                    r.school_type == "SCHOOLE_HIGHSCHOOL" ? r : []
                ) ?? [];
            this.university =
                data?.user_school?.flatMap((r) =>
                    r.school_type == "SCHOOLE_UNIVERSITY" ? r : []
                ) ?? [];
            this.gender = data?.user_information.gender ?? null;
            this.userName = data.name;
        },
    },
    mounted() {
        this.getUserInformation();
        let currentYear = new Date().getFullYear() + 10;
        for (let i = currentYear; i >= 1970; i--) {
            this.years.push(i);
        }
    },
    methods: {
        addHighSchoolInput() {
            this.highSchool.push({
                id: null,
                school_name: "",
                start_year: "",
                end_year: "",
            });
        },
        deleteHighSchool(index) {
            this.highSchool.splice(index, 1);
        },
        addUniversityInput() {
            this.university.push({
                id: null,
                school_name: "",
                start_year: "",
                end_year: "",
            });
        },
        deleteUniversity(index) {
            this.university.splice(index, 1);
        },
        async saveInformation() {
            let _this = this;
            let data = {
                living_place: this.livingPlace,
                working_place: this.workingPlace,
                gender: this.gender,
                university: this.university,
                highschool: this.highSchool,
                name: this.userName,
            };
            await updateUserProfile(data)
                .then((result) => {
                    useToast().success(this.$t('user_setting.info.update_success'));
                    _this.$store.state.user = result.data;
                })
                .catch((err) => {
                    useToast().error(this.$t('user_setting.info.update_error'));
                });
        },
        getUserInformation() {
            getProfile()
                .then((result) => {
                    this.user = result.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
<style scoped>
.btn-add-school {
    width: 100%;
}

.btn-delete-school {
    justify-content: center;
    align-items: center;
    display: flex;
}
</style>
