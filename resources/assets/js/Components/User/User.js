import React, { Component } from 'react';
import Axios from 'axios';

import Pagination from '../Pagination/Pagination';

import {apiUrl} from "../../Helpers/index";

import './User.css';

export default class User extends Component {
    constructor(props) {
        super();

        this.props = props;
        this.state = {};
    }

    componentWillMount() {
        this.getComments();
    }

    getComments(page = 1) {
        const userId = this.props.match.params.id;

        Axios.get(`${apiUrl}usercomments/${userId}?page=${page}`)
        // Axios.get(`${apiUrl}usercomments/9?page=${page}`)
            .then(response => {
                this.setState({
                    user: response.data,
                    comments: response.data.item
                });
            })
            .catch(error => console.log(error))
    }

    render() {
        const user = this.state.user;
        const comments = this.state.comments;

        if (user) {
            return (
                <div className="user">
                    <div className="user__title">
                        <span>Пользователь сайта</span>
                    </div>
                    <div className="user__name">
                        {user.email}
                    </div>
                    <div className="user__comments">
                        <div className="user__subtitle">
                            <span>Комметнарии пользователя:</span>
                        </div>
                        {
                            comments.map((comment, index) => (
                                <div key={index + user.currentPage} className="comment">
                                    <span>{comment}</span>
                                </div>
                            ))
                        }
                        <Pagination activePage={user.currentPage} pagination={user.countPages} callback={this.getComments.bind(this)} />
                    </div>
                </div>
            );
        } else {
            return(
                <div className="user">
                    <span>Loading...</span>
                </div>
            );
        }
    }
}