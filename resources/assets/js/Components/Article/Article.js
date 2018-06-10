import React, {Component} from 'react';
import {Link} from 'react-router-dom';
import Axios from 'axios';

import './Article.css';

import {apiUrl} from "../../Helpers/index";

import ActiveUser from './ActiveUser';

export default class Article extends Component {
    constructor(props) {
        super();

        this.state = {};
        this.props = props;

        this.comment = React.createRef();
    }

    componentWillMount() {
        const articleId = this.props.match.params.id;
        let isLogin = 0;
        let userName = '';

        if (localStorage.getItem('isLogin') !== null) {
            isLogin = localStorage.getItem('isLogin');
        }

        if (localStorage.getItem('userName') !== null) {
            userName = localStorage.getItem('userName');

            this.setState({
                userName: userName
            });
        }

        Axios.get(`${apiUrl}article/${articleId}?islogin=${isLogin}`)
            .then(response => {
                this.setState({
                    article: response.data,
                    count: response.data.article.number_of_views
                });
            })
            .catch(error => console.log(error));


        this.getComments();
    }

    getComments() {
        const articleId = this.props.match.params.id;

        Axios.get(`${apiUrl}getcomments/${articleId}`)
            .then(response => {
                this.setState({
                    comments: response.data
                });
            })
            .catch(error => console.log(error))
    }

    sendCountOfView(count = 0) {
        const articleId = this.props.match.params.id;

        Axios.get(`${apiUrl}setnumviews/${articleId}?count=${count}`)
            .then(response => {
                // this.setState({
                //     count: response.data.newCount
                // });
            })
            .catch(error => console.log(error));
    }

    sendComment() {
        const comment = this.comment.current.value;
        const email = this.state.userName;
        const id = this.state.article.article.id;

        Axios({
            url: `${apiUrl}addcomment`,
            method: 'POST',
            data: {
                content: comment,
                newsId: id,
                userEmail: email
            },
            headers: {
                'Content-type': 'application/json',
                'Access-Control-Allow-Origin': '*'
            }

            })
            .then(response => {
                // this.setState((prevState) => {
                //     comments: prevState.comments.push({
                //         email: email,
                //         created_at: Date.now(),
                //         comment_text: comment
                //     })
                // });
                this.getComments();
            })
            .catch(error => console.log(error));
    }

    render() {
        const article = this.state.article;
        const count = this.state.count;
        const comments = this.state.comments;
        const userName = this.state.userName;

        if (!article) {
            return (
                <div className="article">
                    Loading...
                </div>
            )
        } else {
            return (
                <div className="article">
                    <div className="article__title">
                        <span>{article.article.title}</span>
                    </div>
                    <div className="article__subtitle">
                        <div className="article__category">
                            <span>{article.article.category_name}</span>
                        </div>
                        <div className="article__created-at">
                            <span>{article.article.created_at}</span>
                        </div>
                    </div>
                    <div className="article__active-users">
                        <ActiveUser users={count} callback={this.sendCountOfView.bind(this)}/>
                    </div>
                    <div className="article__tags">
                        {
                            article.tags.map((tag) => (
                                <Link className="article__tag" to={'/tag/' + tag.id} key={tag.id}>#{tag.name}</Link>
                            ))
                        }
                    </div>
                    <div className="article__picture">
                        <img className="picture" src={article.article.img} alt=""/>
                    </div>
                    <div className="article__text">
                        <span>{article.article.content}</span>
                    </div>
                    <div className="article__comments">
                        {
                            comments ? (
                                comments.map((comment, index) => (
                                    <div key={index} className="comment">
                                        <div className="comment__author">
                                            <span>{comment.email}</span>
                                        </div>
                                        <div className="comment__date">
                                            <span>{comment.created_at}</span>
                                        </div>
                                        <div className="comment__text">
                                            <span>{comment.comment_text}</span>
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <span>Єту статью еще никто не комментировал</span>
                            )
                        }
                    </div>
                    <div className="article__new-comment">
                        {
                            userName ? (
                                <div className="new-comment">
                                    <textarea cols="30" rows="10" ref={this.comment}></textarea>
                                    <button onClick={this.sendComment.bind(this)}>Отправить</button>
                                </div>
                            ) : (<p></p>)
                        }
                    </div>
                </div>
            );
        }
    }
}