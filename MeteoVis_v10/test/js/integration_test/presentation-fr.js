QUnit.test( "Data presentation FR", function( assert ) {
    assert.equal( htmlDecode(N('mot').d('d').addComp(N('sarcasme').en('"')).toString()), "le mot « sarcasme »", 'guillemets' );
    assert.equal( htmlDecode(S(Pro('ça'), V('dire').add(NP(N('défense'),PP(P('de'),V('passer'))).en('"'))).a('...').toString()), "Ça dit « défense de passer »...", 'citation' );
    assert.equal( htmlDecode(J(CP(S(Pro('je'),V('venir')),S(Pro('je'),V('voir')),S(Pro('je'),V('vaincre'))).c(',').f('pc').en('"'),N('Jules César').b('— ')).toString()), "« Je suis venu, j'ai vu, j'ai vaincu. » — Jules César", 'passé composé à travers coordination de phrases, ajout avant un élément' );
    assert.equal( NP(D('un'),N('voiture'),I(A('beau'))).n('p'), "des <i>belles</i> voitures", 'accord à travers balise HTML' );
    assert.equal( B(N('camion')).n('p').d('i'), "des <b>camions</b>", 'assignation de traits à travers balise HTML' );
    assert.equal( NP(D('un'),N('voiture'),A('beau').tag('i')).n('p'), "des <i>belles</i> voitures", 'tag(): alternative pour balise HTML simple' );
    assert.equal( P(S('allô').t('int'),S(Pro('qui'),VP(V('être'),Adv('là'))).a('?')), "<p>Allô? Qui est là?</p>", 'plusieurs phrases dans un paragraphe, phrase à partir d\'une chaîne, phrases interrogatives' );
    assert.equal( Img().class('left').src('http://daou.st/JSreal/JSrealIcon.png'),'<img class="left" src="http://daou.st/JSreal/JSrealIcon.png">', 'balise HTML sans fermeture et avec attributs' );
    assert.equal( Div().attr('show', 1), '<div show="1"></div>', 'balise HTML avec attribut inconnu' );
    assert.equal( P().attr({ id:'cont', class:'no-bg', show:1 }), '<p id="cont" class="no-bg" show="1"></p>', 'assignation d\'attributs par objet' );
    assert.equal( CP(C('et'),N('A'),B(N('B')),N('C'),N('D')), 'A, <b>B</b>, C et D', 'balise HTML dans une coordination' );
    assert.equal( J(N('A'),N('B'),N('C')).tag('ol'), "<ol><li>A</li><li>B</li><li>C</li></ol>", 'liste automatique à partir d\'éléments joints' );
    assert.equal( UL(J(N('A'), N('B'), N('C'))), "<ul><li>A B C</li></ul>", 'mais juxtaposition dans liste n\'en prend qu\'une ligne' );
    assert.equal( NP(N('test').en('*')).cap(1), '*Test*', 'majuscule à travers entourage' );
    assert.equal( UL(N('A'),N('B'),N('C')), '<ul><li>A</li><li>B</li><li>C</li></ul>', 'liste automatique dans UL' );
    assert.equal( UL('A','B','C'), '<ul><li>A</li><li>B</li><li>C</li></ul>', 'éléments DOM acceptent chaînes' );
    assert.equal( H4(NP(D('un'),N('voiture'),A('rouge'),A('beau'))), '<h4>Une belle voiture rouge</h4>', 'majuscule automatique à titre HTML' );
//    assert.equal( , '', '' );
});