/**
 * ReactJS app router
 *
 * @date 9/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

ReactDOM.render(
  <Router history={browserHistory}>
    <Route path="/" component={App}>
      <IndexRoute component={Home}/>
      <Route path="about" component={About}>
        <Route path="stuff" component={Stuff}/>
      </Route>
      <Route path="contact" component={Contact}/>
      <Route path="login" component={Login}/>
      <Route path="signup" component={Signup}/>
      <Route path="logout" component={Logout}/>
      <Route path="my" component={My}/>
      <Route path="my/add" component={AddTodo}/>
    </Route>
  </Router>,
  document.getElementById('container')
);