use std::fs;
use std::collections::HashMap;

type LeafPos = Vec<usize>;

#[derive(Debug, Clone)]
struct Tree {
    id: String,
    pos: LeafPos,
    childs: Vec<Tree>
}

impl Tree {
    pub fn new(id: &str) -> Tree {
        Tree {id: String::from(id), pos: vec![], childs: vec![]}
    }

    pub fn add(&mut self, child: Tree){
        child.pos = self.pos.clone();
        child.pos.push(self.childs.len());
        self.childs.push(child);
    }

    pub fn get_mut(&mut self, pos: LeafPos) -> Option<& mut Tree>{
        let numChild = pos[0];
        if pos.len() == 1 {
            if self.childs.len() <= numChild {
                return None;
            }
            return Some(&mut self.childs[numChild]);
        }
        let pos = &pos[1..];
        self.childs[numChild].get_mut(pos.to_vec())
    }

    pub fn add_at(&mut self, pos: LeafPos, child: Tree){
        let numChild = pos[0];
        if pos.len() == 1 {
            self.childs[numChild].add(child);
        } else {
            let pos = &pos[1..];
            self.childs[numChild].add_at(pos.to_vec(), child);
        }
    }

    pub fn count(&self) -> usize {
        let childCounts: Vec<usize> = self.childs.iter().map(|t| t.count()).collect();
        childCounts.into_iter().sum::<usize>() + self.childs.len()
    }

    pub fn find(&self, id: &str) -> Option<LeafPos> {
        for child in &self.childs {
            if child.id == id {
                return Some(child.pos.clone());
            }
            let found = child.find(&id);
            if found.is_some() {
                return found;
            }
        }
        None
    }
}

fn locate_or_create<'a>(maybe_otree: &'a mut Option<Tree>, pending: &'a mut HashMap<String, Tree>, id: &'a str) -> &'a mut Tree {
    if maybe_otree.is_some() {
        let otree: &mut Tree = maybe_otree.as_mut().unwrap();
        let pos = otree.find(id);
        if pos.is_some() {
            let found = otree.get_mut(pos.unwrap());
            if found.is_some(){
                return found.unwrap();
            }
        }
    }

    pending.entry(id.to_string()).or_insert(Tree::new(id));
    pending.get_mut(id).unwrap()
}

fn add_childs(&otree: &mut Tree, &mut HashMap<String, &Tree>){
   
}

fn main() {
    let contents = fs::read_to_string("day6input.txt")
        .expect("Something went wrong reading the file");
    let orbs: Vec<Vec<&str>> = contents.lines().into_iter().map(|line| {
        let orb: Vec<&str> = line.split(")").collect();
        orb
    // let state: Vec<usize> = contents.trim().split(",").map(|s| s.parse().unwrap()).collect();
    }).collect();
    println!("{:?}", &orbs[0]);

    let mut pendingTrees: HashMap<String, &Tree> = HashMap::new();

    // for orb in orbs {
    //     let o_in = locate_or_create(&mut orbit_tree, &mut pendingTrees, orb[0]);
    //     let o_out = locate_or_create(&mut orbit_tree, &mut pendingTrees, orb[1]);
    //     o_in.add(*o_out);
    // }

    //First pass : create hashmap of leafs
    for orb in &orbs {
        for i in 0..1 {
            pendingTrees.entry(orb[i].to_string()).or_insert(&Tree::new(orb[i]));
        }
    }

    let mut otree: Tree = pendingTrees.get("COM").clone();

    add_childs(&otree, &orbs);

    let mut tree = Tree::new("COM");
    tree.add(Tree::new("AA"));
    tree.add(Tree::new("BB"));
    tree.add_at(vec![1], Tree::new("CC"));
    tree.add_at(vec![1,0], Tree::new("DD"));
    println!("{:?}", tree);
    println!("{:?}", tree.find("DD"));
    println!("{}", tree.count());

}
