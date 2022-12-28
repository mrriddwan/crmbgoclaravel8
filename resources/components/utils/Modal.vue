<template>
    <transition name="modal-fade">
        <!-- <div class="modal-backdrop"> -->
        <div
            class="modal"
            role="dialog"
            aria-labelledby="modalTitle"
            aria-describedby="modalDescription"
        >
            <header class="modal-header" id="modalTitle">
                <slot name="header"> This is the default tile! </slot>
                <button
                    type="button"
                    class="btn-close"
                    @click="close"
                    aria-label="Close modal"
                >
                    x
                </button>
            </header>

            <section class="modal-body" id="modalDescription">
                <slot name="body"> This is the default body! </slot>
            </section>

            <!-- <footer class="modal-footer">
                <slot name="footer"> This is the default footer! </slot>
                <button
                    type="button"
                    class="btn-green"
                    @click="close"
                    aria-label="Close modal"
                >
                    X
                </button>
            </footer> -->
        </div>
        <!-- </div> -->
    </transition>
</template>

<script>
export default {
    name: "Modal",
    props: ["annc_reminder_id"],
    methods: {
        close() {
            this.$emit("close");
        },
    },
    data() {
        return {
            users: [],
            annc_reminder: [""],
        };
    },

    mounted() {
        this.getUsers();
        this.getSelectedAnnouncementReminder();
    },

    methods: {
        async getSelectedAnnouncementReminder() {
            await axios
                .get(
                    "/api/admin/announcement_reminder/" +
                        this.$props.annc_reminder_id
                )
                .then((res) => {
                    this.annc_reminder = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getUsers() {
            await axios
                .get("/api/users/index")
                .then((res) => {
                    this.users = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style>
.modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal {
    background: #ffffff;
    box-shadow: 2px 2px 20px 1px;
    overflow-x: auto;
    display: flex;
    left: 25%;
    top: 25%;
    flex-direction: column;
    width: 50vw;
    height: max-content;
    /* margin: auto; */
}

.modal-header,
.modal-footer {
    padding: 15px;
    display: flex;
}

.modal-header {
    position: relative;
    border-bottom: 1px solid #eeeeee;
    color: #4aae9b;
    justify-content: space-between;
}

.modal-footer {
    border-top: 1px solid #eeeeee;
    flex-direction: column;
}

.modal-body {
    position: relative;
    padding: 20px 10px;
}

.btn-close {
    position: absolute;
    top: 0;
    right: 0;
    border: none;
    font-size: 20px;
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    color: #4aae9b;
    background: transparent;
}

.btn-green {
    color: white;
    background: #4aae9b;
    border: 1px solid #4aae9b;
    border-radius: 2px;
}

.modal-fade-enter,
.modal-fade-leave-to {
    opacity: 0;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
    transition: opacity 0.5s ease;
}
</style>
